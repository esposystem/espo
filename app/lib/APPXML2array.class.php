<?PHP 
/*************************************************************************/ 
/* This class stores associative arrays in an xml formated string.       */ 
/* There's also a function thar retrieves them. If you try to use        */  
/* xml2array with a general xml, it can fail, since there can be some    */ 
/* repeated indexes....                                                  */ 
/*************************************************************************/ 


class assoc_array2xml { 
    var $text; 
    var $arrays, $keys, $node_flag, $depth, $xml_parser; 
    /*Converts an array to an xml string*/ 
    function array2xml($array,$root) { 
    //global $text; 
    $this->text="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><$root>"; 
    $this->text.= $this->array_transform($array); 
    $this->text .="</$root>"; 
    return $this->text; 
    } 
    
    function array_transform($array){ 
    //global $array_text; 
    foreach($array as $key => $value){ 
    if(!is_array($value)){ 
     $this->text .= "<$key>$value</$key>"; 
     } else { 
     $this->text.="<$key>"; 
     $this->array_transform($value); 
     $this->text.="</$key>"; 
     } 
    } 
    return $array_text; 
    
    }
    
    function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    
   // echo $xml_values;
    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
				print_r($var);
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
   
    return($xml_array);
}

    /*Transform an XML string to associative array "XML Parser Functions"*/ 
    function xml2array2($xml){ 
    $this->depth=-1; 
    $this->xml_parser = xml_parser_create(); 
    xml_set_object($this->xml_parser, $this); 
    xml_parser_set_option ($this->xml_parser,XML_OPTION_CASE_FOLDING,0);//Don't put tags uppercase 
    xml_set_element_handler($this->xml_parser, "startElement", "endElement"); 
    xml_set_character_data_handler($this->xml_parser,"characterData"); 
    xml_parse($this->xml_parser,$xml,true); 
    xml_parser_free($this->xml_parser); 
    return $this->arrays[0]; 
    
    } 
    function startElement($parser, $name, $attrs) 
     { 
       $this->keys[]=$name; //We add a key 
       $this->node_flag=1; 
       $this->depth++; 
     } 
    function characterData($parser,$data) 
     { 
       $key=end($this->keys); 
       $this->arrays[$this->depth][$key]=$data; 
       $this->node_flag=0; //So that we don't add as an array, but as an element 
     } 
    function endElement($parser, $name) 
     { 
       $key=array_pop($this->keys); 
       //If $node_flag==1 we add as an array, if not, as an element 
       if($this->node_flag==1){ 
         $this->arrays[$this->depth][$key]=$this->arrays[$this->depth+1]; 
         unset($this->arrays[$this->depth+1]); 
       } 
       $this->node_flag=1; 
       $this->depth--; 
     } 
    
    }//End of the class 

?> 