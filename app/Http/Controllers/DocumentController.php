<?php

namespace App\Http\Controllers;

use App\Models\PatientReport;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Http\Request;
use HTMLPurifier;
use HTMLPurifier_Config;
use PhpOffice\PhpWord\Shared\Html;

class DocumentController extends Controller
{
    public function edit($id)
    {
        $document = PatientReport::findOrFail($id);
        $filePath = storage_path($document->file_path);

        // Load the document
        $phpWord = IOFactory::load($filePath);

        // Use the HTML Writer to convert the document to HTML
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlWriter->save(storage_path('temp.html'));

        $content = file_get_contents(storage_path('temp.html'));
        unlink(storage_path('temp.html')); // Clean up the temporary file

        // Clean up HTML content
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $content = $purifier->purify($content);

        return view('document.edit', compact('content', 'id'));
    }

    public function save(Request $request, $id)
{
    // Validate and retrieve the input
    $validated = $request->validate([
        'content' => 'required|string',
    ]);

    // Retrieve the HTML content as is (without encoding)
    $content = $validated['content'];
    $content = str_replace(
        ['&nbsp;', '&'], 
        ['&#160;', '&amp;'], 
        $content
    );

    // dd($content);

    $document = PatientReport::findOrFail($id);
    $filePath = storage_path($document->file_path);

    // Create a new PHPWord object
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Load the HTML content into the Word document
    Html::addHtml($section, $content, false, false);

    // Save the document as a .docx file
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($filePath);

    // Optionally, handle the response
    return redirect()->route('document.edit', ['id' => $id])->with('success', 'Document saved successfully!');
}


}
