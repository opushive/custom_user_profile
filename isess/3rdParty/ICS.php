<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ICS
 *
 * @author tosin
 */
class ICS {

    var $data;
    var $name;

    function __construct($start, $end, $name, $description, $location) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:" . date("Ymd\THis\Z", strtotime($start)) . "\nDTEND:" . date("Ymd\THis\Z", strtotime($end)) . "\nLOCATION:" . $location . "\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:" . date("Ymd\THis\Z") . "\nSUMMARY:" . $name . "\nDESCRIPTION:" . $description . "\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
    }

    function save($_directory) {
        $timestamp = time($_directory);
        if (!is_dir($_directory)) {
            mkdir($_directory);
        }
        $folderPath = $_directory . "/" . $timestamp . ".ics";
        file_put_contents($folderPath, $this->data);
        return $folderPath;
    }

    function show() {
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="' . $this->name . '.ics"');
        Header('Content-Length: ' . strlen($this->data));
        Header('Connection: close');
        echo $this->data;
    }

}
