<?php
require __DIR__ . '/DBAbstractModel.php';

class RawEvents extends DBAbstractModel{
    
       
    public function getJsonResult($eventType) {
        $this->query = "
                SELECT evtTypePk 
                FROM EvtTypes
                WHERE evtShortDesc = '" . $eventType ."'";
        $this->get_results_from_query();
        
        return json_encode($this->rows);
    }
    
    public function setData($id, $tstamp, $value, $metadata) {
        $this->query = "
            INSERT INTO RawEvents (evtTypeFk, tstamp, value, metadata)
            VALUES ('$id','$tstamp','$value','$metadata')
        ";
        $this->execute_single_query();
    }
    
    public function set() {
        
    }
    
    public function get() {
        
    }
    
}