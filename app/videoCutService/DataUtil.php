<?php


class DataUtil
{

    public function setXMLHeader() {
     
        if(ob_get_length() >0) 
	    	ob_clean();
	
        header("Content-type:text/xml");
        echo "<?xml version='1.0'?>";
    }


}