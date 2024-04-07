<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function importView()
    {
        return view('contacts.import');
    }

    public function exportView()
    {
        return view('contacts.export');
    }

    public function importContacts(Request $request)
    {
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));

        $header = array_shift($rows); // Extract header
        $csv = [];
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        foreach ($csv as $key => $row) {
            Contact::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'birthday' => date('Y-m-d', strtotime($row['birthday'])),
                'notes' => $row['notes'],
            ]);
        }

        return redirect()->back()->with('success', 'Contacts imported successfully');
    }
    public function exportContacts()
    {
        $contacts = Contact::all();
        $csvFileName = 'contacts.csv';
        $csvHeaders = ['Name', 'Email', 'Birthday', 'Notes']; // Add more fields as needed

        $file = fopen($csvFileName, 'w');
        fputcsv($file, $csvHeaders);

        foreach ($contacts as $contact) {
            fputcsv($file, [$contact->name, $contact->email, $contact->birthday, $contact->notes]); // Add more fields as needed
        }

        fclose($file);

        return response()->download($csvFileName)->deleteFileAfterSend();
    }
}
