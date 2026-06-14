<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SusExport implements WithEvents, ShouldAutoSize, WithTitle
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function title(): string
    {
        return 'Evaluasi SUS';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $dbEvent = Event::findOrFail($this->eventId);
                
                // Set Title
                $sheet->setCellValue('A1', 'LAPORAN EVALUASI SYSTEM USABILITY SCALE (SUS) - ARQAM APP');
                $sheet->mergeCells('A1:P1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('A2', 'Event: ' . $dbEvent->nama_event);
                $sheet->mergeCells('A2:P2');
                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Section: Pertanyaan
                $sheet->setCellValue('A4', 'DAFTAR INSTRUMEN PERTANYAAN KUESIONER SUS:');
                $sheet->getStyle('A4')->getFont()->setBold(true);

                $susItems = AngketItem::where('event_id', $this->eventId)->where('kategori', 'SUS')->orderBy('urutan')->get();
                $row = 5;
                foreach ($susItems as $idx => $item) {
                    $sheet->setCellValue('A' . $row, 'Q' . ($idx + 1));
                    $sheet->setCellValue('B' . $row, $item->teks_item);
                    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                    $row++;
                }

                // Empty row and Section: Responden
                $row += 1;
                $sheet->setCellValue('A' . $row, 'DATA RESPONDEN DAN PERHITUNGAN SKOR SUS:');
                $sheet->getStyle('A' . $row)->getFont()->setBold(true);

                $row += 1;
                $headerRow = $row;
                // Headers
                $headers = [
                    'No', 'Nama Lengkap', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10',
                    'Skor SUS', 'Grade', 'Adjective Rating', 'Acceptability'
                ];
                
                $colLetters = range('A', 'P');
                foreach ($headers as $colIdx => $headerText) {
                    $colLetter = $colLetters[$colIdx];
                    $sheet->setCellValue($colLetter . $headerRow, $headerText);
                }

                $sheet->getStyle("A{$headerRow}:P{$headerRow}")->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
                $sheet->getStyle("A{$headerRow}:P{$headerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F4E79'); // Dark Blue
                $sheet->getStyle("A{$headerRow}:P{$headerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Data Rows
                $pesertas = EventPeserta::where('event_id', $this->eventId)
                    ->where('status_aktif', true)
                    ->with('peserta')
                    ->get();

                $susItemIds = $susItems->pluck('id')->toArray();
                $dataStartRow = $headerRow + 1;
                $currentRow = $dataStartRow;
                $no = 1;

                foreach ($pesertas as $ep) {
                    $p = $ep->peserta;
                    if (!$p) continue;

                    $answers = AngketJawaban::where('event_id', $this->eventId)
                        ->where('peserta_id', $p->id)
                        ->whereIn('item_id', $susItemIds)
                        ->get()
                        ->keyBy('item_id');

                    // Skip or show empty if not filled
                    if ($answers->count() === 10) {
                        $sheet->setCellValue('A' . $currentRow, $no++);
                        $sheet->setCellValue('B' . $currentRow, $p->nama_lengkap);

                        // Q1 to Q10 answers
                        foreach ($susItems as $idx => $item) {
                            $ansVal = (int)($answers[$item->id]->jawaban ?? 3);
                            $colLetter = $colLetters[$idx + 2];
                            $sheet->setCellValue($colLetter . $currentRow, $ansVal);
                        }

                        // Formula for SUS Score (Column M / Column 13)
                        $susFormula = "=( (C{$currentRow}-1) + (5-D{$currentRow}) + (E{$currentRow}-1) + (5-F{$currentRow}) + (G{$currentRow}-1) + (5-H{$currentRow}) + (I{$currentRow}-1) + (5-J{$currentRow}) + (K{$currentRow}-1) + (5-L{$currentRow}) ) * 2.5";
                        $sheet->setCellValue('M' . $currentRow, $susFormula);

                        // Grade Formula (Column N)
                        $gradeFormula = "=IF(M{$currentRow}>=80.3,\"A\",IF(M{$currentRow}>=68.0,\"B/C\",IF(M{$currentRow}>=51.0,\"D\",\"F\")))";
                        $sheet->setCellValue('N' . $currentRow, $gradeFormula);

                        // Adjective Rating Formula (Column O)
                        $adjFormula = "=IF(M{$currentRow}>=80.3,\"Excellent\",IF(M{$currentRow}>=68.0,\"Good\",IF(M{$currentRow}>=51.0,\"Okay\",\"Poor\")))";
                        $sheet->setCellValue('O' . $currentRow, $adjFormula);

                        // Acceptability Formula (Column P)
                        $acceptFormula = "=IF(M{$currentRow}>=68.0,\"Acceptable\",IF(M{$currentRow}>=51.0,\"Marginal\",\"Unacceptable\"))";
                        $sheet->setCellValue('P' . $currentRow, $acceptFormula);

                        $currentRow++;
                    }
                }

                $dataEndRow = $currentRow - 1;

                if ($dataEndRow >= $dataStartRow) {
                    // Average Row
                    $sheet->setCellValue('B' . $currentRow, 'RATA-RATA SKOR SUS');
                    $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);

                    // Average SUS score formula
                    $avgSusFormula = "=AVERAGE(M{$dataStartRow}:M{$dataEndRow})";
                    $sheet->setCellValue('M' . $currentRow, $avgSusFormula);
                    $sheet->getStyle('M' . $currentRow)->getFont()->setBold(true);

                    // Average Grade Formula
                    $avgGradeFormula = "=IF(M{$currentRow}>=80.3,\"A\",IF(M{$currentRow}>=68.0,\"B/C\",IF(M{$currentRow}>=51.0,\"D\",\"F\")))";
                    $sheet->setCellValue('N' . $currentRow, $avgGradeFormula);
                    $sheet->getStyle('N' . $currentRow)->getFont()->setBold(true);

                    // Average Adjective Formula
                    $avgAdjFormula = "=IF(M{$currentRow}>=80.3,\"Excellent\",IF(M{$currentRow}>=68.0,\"Good\",IF(M{$currentRow}>=51.0,\"Okay\",\"Poor\")))";
                    $sheet->setCellValue('O' . $currentRow, $avgAdjFormula);
                    $sheet->getStyle('O' . $currentRow)->getFont()->setBold(true);

                    // Average Acceptability Formula
                    $avgAcceptFormula = "=IF(M{$currentRow}>=68.0,\"Acceptable\",IF(M{$currentRow}>=51.0,\"Marginal\",\"Unacceptable\"))";
                    $sheet->setCellValue('P' . $currentRow, $avgAcceptFormula);
                    $sheet->getStyle('P' . $currentRow)->getFont()->setBold(true);

                    // Apply styles to the Average row
                    $sheet->getStyle("A{$currentRow}:P{$currentRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE9EEF4');
                    $sheet->getStyle("A{$currentRow}:P{$currentRow}")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle("A{$currentRow}:P{$currentRow}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE);

                    // Format numbers to 2 decimals for Score
                    $sheet->getStyle("M{$dataStartRow}:M{$currentRow}")->getNumberFormat()->setFormatCode('0.00');

                    // Apply Borders to Data Table
                    $styleRange = "A{$headerRow}:P{$currentRow}";
                    $sheet->getStyle($styleRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                }
            }
        ];
    }
}
