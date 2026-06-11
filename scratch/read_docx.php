<?php
$zip = new ZipArchive;
if ($zip->open('Soal Pretest BA Dosen.docx') === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    if ($xml) {
        // Hapus tag XML untuk mendapatkan teks bersih
        $clean_text = strip_tags($xml, '<w:p><w:r><w:t>');
        
        // Menggunakan DOMDocument untuk memparsing teks dengan paragraf rapi
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $paragraphs = $dom->getElementsByTagName('p');
        foreach ($paragraphs as $p) {
            $text = '';
            $texts = $p->getElementsByTagName('t');
            foreach ($texts as $t) {
                $text .= $t->nodeValue;
            }
            if (trim($text) !== '') {
                echo $text . "\n";
            }
        }
    } else {
        echo "word/document.xml tidak ditemukan\n";
    }
    $zip->close();
} else {
    echo "Gagal membuka file docx\n";
}
