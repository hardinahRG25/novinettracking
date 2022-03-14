<?php

/*
 * Author: Hardinah
 * start Pdf.php file
 * Location: ./application/libraries/Pdf.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once dirname(__FILE__) . '/TCPDF/tcpdf.php';

class Mypdf extends TCPDF {

//Page header
    public function Header() {
        $this->SetFont('helvetica', 'B', 10);
        $header = $this->headerFile();
        $this->writeHTML($header, false, false, false, false, 'C');
    }

// Page footer
    public function Footer() {
// Position at 15 mm from bottom
        $this->SetY(-25);
// Set font
        $this->SetFont('helvetica', 'I', 8);
        $signArray = $this->signFile();
        foreach ($signArray as $key => $value) {
            $this->writeHTML($signArray[$key], false, false, false, false, 'L');
        }
    }

    public function signFile() {
        $sign = array();
        $sign[] = "<p style='margin:0px;font-size:12px;color:#aaa'>KURVE</p>";
        $sign[] = "<p style='margin:0px;font-size:12px;color:#aaa'>Exploitation Applicative & SVA</p>";
        $sign[] = "<p style='margin:0px;font-size:12px;color:#aaa'>Direction des Systèmes d’Information</p>";
        $sign[] = "<p style='margin:0px;font-size:12px;color:#aaa'>TELMA</p>";
        $sign[] = date('H:m d/m/Y');
        return $sign;
    }

    public function headerFile() {
        $image_file = FCPATH . "assets/images/telma.png";
        $logo = $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $headerArray = '';
        $headerArray .= "<div>";
        $headerArray .= "<table style='width: 100%;border: 2px solid red;text-align: center;'>";
        $headerArray .= "<tr>";
        $headerArray .= "<td></td>";
        $headerArray .= "<td colspan = '3'>";
        $headerArray .= "Change request (SSI) <br/> Mode opératoire</td>";
        $headerArray .= "<td style = 'text-align:right'>Date: " . date('d/m/Y') . "</td>";
        $headerArray .= "</tr>";
        $headerArray .= "</table>";
        $headerArray .= "</div>";
        return $headerArray;
    }

}
