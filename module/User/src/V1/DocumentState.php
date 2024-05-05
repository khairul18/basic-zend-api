<?php
namespace User\V1;

class DocumentState
{
    const STATE_1    = "ID Card and Family ID Card Uploaded";
    const STATE_1_OK = "ID Card and Family ID Card Verified";
    const STATE_2    = "New Passpor Document Uploaded";
    const STATE_2_OK = "New Passpor Document Verified";
    const STATE_3    = "Vaccine Uploaded";
    const STATE_3_OK = "Vaccine Verified";
    const STATE_4    = "Passpor Uploaded";
    const STATE_4_OK = "Passpor Verified";
    const COMPLETED  = "Document Completed";
}
