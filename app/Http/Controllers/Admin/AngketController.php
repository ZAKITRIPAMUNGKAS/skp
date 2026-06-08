<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use App\Models\AngketKomentar;
use App\Models\Event;
use App\Models\EventPeserta;
use Illuminate\Http\Request;

class AngketController extends Controller
{
    public function storeItem(Request $request, Event $event)
    {
        $request->validate([
            'kategori'  => 'required|in:A,B,C,D,E,F,G,H,I',
            'teks_item' => 'required|string',
            'tipe'      => 'nullable|in:skala,voting',
        ]);

        $maxUrutan = AngketItem::where('event_id', $event->id)->where('kategori', $request->kategori)->max('urutan') ?? 0;

        $item = AngketItem::create([
            'event_id' => $event->id,
            'kategori' => $request->kategori,
            'teks_item'=> $request->teks_item,
            'tipe'     => $request->tipe ?? 'skala',
            'urutan'   => $maxUrutan + 1,
        ]);

        return response()->json(['status' => 'success', 'item' => $item]);
    }

    public function updateItem(Request $request, Event $event, AngketItem $item)
    {
        $request->validate([
            'teks_item' => 'required|string',
            'kategori'  => 'nullable|in:A,B,C,D,E,F,G,H,I',
            'tipe'      => 'nullable|in:skala,voting',
        ]);
        
        $item->update([
            'teks_item' => $request->teks_item,
            'kategori'  => $request->kategori ?? $item->kategori,
            'tipe'      => $request->tipe ?? $item->tipe,
        ]);
        
        return response()->json(['status' => 'success', 'item' => $item]);
    }

    public function destroyItem(Event $event, AngketItem $item)
    {
        $item->delete();
        return response()->json(['status' => 'success']);
    }

    public function reorderItems(Request $request, Event $event)
    {
        foreach ($request->order as $o) {
            AngketItem::where('id', $o['id'])->where('event_id', $event->id)->update(['urutan' => $o['urutan']]);
        }
        return response()->json(['status' => 'success']);
    }

    public function summary(Event $event)
    {
        $items = AngketItem::where('event_id', $event->id)->orderBy('kategori')->orderBy('urutan')->get();
        $totalPeserta = EventPeserta::where('event_id', $event->id)->where('status_aktif', true)->count();

        $summaryData = $items->map(function ($item) use ($event) {
            $counts = AngketJawaban::where('event_id', $event->id)->where('item_id', $item->id)
                ->selectRaw("jawaban, COUNT(*) as cnt")->groupBy('jawaban')->pluck('cnt', 'jawaban')->toArray();
            $totalResp = array_sum($counts);

            if ($item->tipe === 'voting') {
                $votingResults = [];
                if ($totalResp > 0) {
                    $pesertaIds = array_keys($counts);
                    $pesertas = \App\Models\Peserta::whereIn('id', $pesertaIds)->pluck('nama_lengkap', 'id');
                    foreach ($counts as $pId => $cnt) {
                        if (isset($pesertas[$pId])) {
                            $votingResults[] = [
                                'nama' => $pesertas[$pId],
                                'votes' => $cnt
                            ];
                        }
                    }
                    usort($votingResults, fn($a, $b) => $b['votes'] <=> $a['votes']);
                }

                return [
                    'id' => $item->id, 'kategori' => $item->kategori, 'teks_item' => $item->teks_item,
                    'tipe' => $item->tipe,
                    'voting_results' => $votingResults,
                    'total_resp' => $totalResp,
                ];
            }

            $scoreMap = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1];
            $avgScore = $totalResp > 0
                ? round(array_sum(array_map(fn($k, $v) => ($scoreMap[$k] ?? 0) * $v, array_keys($counts), array_values($counts))) / $totalResp, 2)
                : 0;

            return [
                'id' => $item->id, 'kategori' => $item->kategori, 'teks_item' => $item->teks_item,
                'tipe' => $item->tipe ?? 'skala',
                'counts' => ['A' => $counts['A'] ?? 0, 'B' => $counts['B'] ?? 0, 'C' => $counts['C'] ?? 0, 'D' => $counts['D'] ?? 0],
                'avg_score' => $avgScore, 'total_resp' => $totalResp,
            ];
        });

        $comments = AngketKomentar::where('event_id', $event->id)
            ->with('peserta:id,nama_lengkap')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['items' => $summaryData, 'comments' => $comments, 'total_peserta' => $totalPeserta]);
    }
}
