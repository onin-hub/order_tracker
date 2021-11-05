<?php 
class Document {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllDocument() {
        $qAllDoc = "SELECT * FROM `documents`";
        $rAllDoc = $this->db_handle->runBaseQuery($qAllDoc);

        return $rAllDoc;
    }

    function getDocumentByLevel($level) {
        $qDocLevel = "SELECT * FROM `documents` WHERE `level` = :lvl";

        $pDocLevel = [
            'lvl' => $level
        ];

        $rDocLevel = $this->db_handle->runBaseQuery($qDocLevel, $pDocLevel);

        return $rDocLevel;
    }

    function getDocumentByAuthor($author) {
        $qDocAuthor = "SELECT * FROM `documents` WHERE `author` = :author";

        $pDocAuthor = [
            'author' => $author
        ];

        $rDocAuthor = $this->db_handle->runBaseQuery($qDocAuthor, $pDocAuthor);

        return $rDocAuthor;
    }

    function addDoc($title, $type, $description, $tags, $filename, $date_uploaded, $revision, $author, $size, $remarks, $level, $status, $state) {
        $qAddDoc = "INSERT INTO `documents` 
        (`title`,`type`,`description`,`tags`,`filename`,`date_uploaded`,`revision`,`author`,`size`,`remarks`,`level`,`status`,`state`) 
        VALUES (:title, :typ, :descr, :tags, :filen, :date_uploaded, :rev, :author, :size, :remarks, :lvl, :stat, :ste)";
        
        $pAddDoc = [
            'title' => $title,
            'typ' => $type,
            'descr' => $description,
            'tags' => $tags,
            'filen' => $filename,
            'date_uploaded' => $date_uploaded,
            'rev' => $revision,
            'author' => $author,
            'size' => $size,
            'remarks' => $remarks,
            'lvl' => $level,
            'stat' => $status,
            'ste' => $state,
        ];

        $rAddDoc = $this->db_handle->insert($qAddDoc, $pAddDoc);
        return $rAddDoc;
    }

    function updateDoc($title, $description, $tags, $remarks, $did) {
        $qUpdDoc = "UPDATE `documents` SET 
        `title` = :title,
        `description` = :descr,
        `tags` = :tags,
        `remarks` = :rmk
        WHERE `id` = :did";

        $pUpdDoc = [
            'title' => $title,
            'descr' => $description,
            'tags' => $tags,
            'rmk' => $remarks,
            'did' => $did
        ];

        $rUpdDoc = $this->db_handle->update($qUpdDoc, $pUpdDoc);
        return $rUpdDoc;
    }

    function getDocByID($did) {
        $qDocID = "SELECT * FROM `documents` WHERE `id` = :did";

        $pDocID = [
            'did' => $did
        ];

        $rDocID = $this->db_handle->runBaseQuery($qDocID, $pDocID);

        return $rDocID;
    }

    function updateRev($doc_rev, $did) {
        $qRevDoc = "UPDATE `documents` SET 
        `revision` = :rev
        WHERE `id` = :did";

        $pRevDoc = [
            'did' => $did,
            'rev' => $doc_rev
        ];

        $rRevDoc = $this->db_handle->update($qRevDoc, $pRevDoc);
        return $rRevDoc;
    }

    function updateState($state, $did) {
        $qSteDoc = "UPDATE `documents` SET 
        `state` = :ste
        WHERE `id` = :did";

        $pSteDoc = [
            'did' => $did,
            'ste' => $state
        ];

        $rSteDoc = $this->db_handle->update($qSteDoc, $pSteDoc);
        return $rSteDoc;
    }

    function updateStatus($status, $did) {
        $qStatDoc = "UPDATE `documents` SET 
        `status` = :stat
        WHERE `id` = :did";

        $pStatDoc = [
            'did' => $did,
            'stat' => $status
        ];

        $rStatDoc = $this->db_handle->update($qStatDoc, $pStatDoc);
        return $rStatDoc;
    }
}
?>