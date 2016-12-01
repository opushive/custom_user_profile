<?php

namespace smash;

/**
 * Description of GenericComponentBuilder
 *
 * @author femi
 */
class GenericComponentBuilder {

    const INPUT_FIELD = 0;

    static function getDropdown() {
        
    }

    static function getInputField($_label, $_fieldname, $_fieldvalue = NULL, $_css = NULL) {
        return "<input id='$_fieldname' name='$_fieldname' type='text' class='code $_css' value='<?php echo esc_attr($_fieldvalue) ?>'
               placeholder='<?php echo('$_label', 'address') ?>' required>";
    }

    static function extractAttrs($_attrs = array()) {
        $atrrs = "";
        if (is_array($_attrs)) {
            foreach ($_attrs as $key => $value) {
                $atrrs .= " " . $key . "='" . $value . "' ";
            };
        };
        return $atrrs;
    }
    /**
     * @param string $_label label of the form field
     */
    static function getRow($_label, $_rowType, $_value = '', $_name = NULL, $_id = NULL, $_attributes = NULL) {
        if (NULL == $_name) {
            $_name = strtolower($_label);
        }
        if (NULL == $_id) {
            $_id = strtolower($_label);
        }
        ?>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="<?php echo($_id) ?>"><?php echo($_label)  ?></label>
            </th>
            <td>
                <?php
                    
                switch ($_rowType) {
                    case "textarea":
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= "form-control";
                            }
                            if (!array_key_exists("placeholder", $_attributes)) {
                                $_attributes["placeholder"] = $_name;
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "form-control";
                            $_attributes["placeholder"] = $_name;
                        }
                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                        <textarea name="<?php echo($_name); ?>" 
                                  class="form-control" 
                                  id="<?php echo($_id); ?>" <?php _e($attrAsString) ?>><?php echo($_value); ?></textarea>
                                  <?php
                                  break;
                    case "text":

                        // add any default arguments
                        if (isset($_attributes)) {
                            if (!array_key_exists("size", $_attributes)) {
                                $_attributes["size"] = 50;
                            }
                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= "form-control";
                            }
                            if (!array_key_exists("placeholder", $_attributes)) {
                                $_attributes["placeholder"] = $_name;
                            }
                        } else {
                            $_attributes = array();
                            $_attributes["size"] = 50;
                            $_attributes["class"] = "form-control";
                            $_attributes["placeholder"] = $_name;
                        }
                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                    <input id="<?php echo($_id) ?>" 
                     name="<?php echo($_name); ?>" 
                     type="text" 
                     value="<?php echo($_value); ?>"
                     <?php echo($attrAsString); ?>
                     >
                     <?php
                     break;
                    case "number":
                     $attrAsString = "";
                     // add any default arguments
                     if (isset($_attributes)) {
                         if (!array_key_exists("size", $_attributes)) {
                             $_attributes["size"] = 50;
                         }
                         if (!array_key_exists("class", $_attributes)) {
                             $_attributes["class"] = "form-control";
                         } else {
                             $_attributes["class"] .= "form-control";
                         }
                         if (!array_key_exists("step", $_attributes)) {
                             $_attributes["step"] = "1";
                         } else {
                             $_attributes["step"] = "step";
                         }
                         if (!array_key_exists("placeholder", $_attributes)) {
                             $_attributes["placeholder"] = $_name;
                         }
                     } else {
                         $_attributes = array();
                         $_attributes["size"] = 50;
                         $_attributes["class"] = "form-control";
                         $_attributes["placeholder"] = $_name;
                         $_attributes["step"] = 1;
                     }
                     $attrAsString = self::extractAttrs($_attributes);
                     ?>
                    <input id="<?php echo($_id) ?>" 
                     name="<?php echo($_name); ?>" 
                     type="number" 
                     value="<?php echo($_value); ?>"
                    <?php echo($attrAsString); ?>
                     >
                     <?php
                     break;
                    case "time":
                     $attrAsString = "";
                     // add any default arguments
                     if (isset($_attributes)) {
                         if (!array_key_exists("size", $_attributes)) {
                             $_attributes["size"] = 50;
                         }
                         if (!array_key_exists("class", $_attributes)) {
                             $_attributes["class"] = "form-control";
                         } else {
                             $_attributes["class"] .= "form-control";
                         }
                         if (!array_key_exists("step", $_attributes)) {
                             $_attributes["step"] = "1";
                         } else {
                             $_attributes["step"] = "step";
                         }
                         if (!array_key_exists("placeholder", $_attributes)) {
                             $_attributes["placeholder"] = $_name;
                         }
                     } else {
                         $_attributes = array();
                         $_attributes["size"] = 50;
                         $_attributes["class"] = "form-control";
                         $_attributes["placeholder"] = $_name;
                         $_attributes["step"] = 1;
                     }
                     $attrAsString = self::extractAttrs($_attributes);
                     ?> 
                    <input id="<?php echo($_id) ?>" 
                     name="<?php echo($_name); ?>" 
                     type="time" 
                     value="<?php echo($_value); ?>"
                     <?php echo($attrAsString); ?>
                     >
                     <?php
                     break;
                    case 'dropdown':
                     $attrAsString = "";
                     $callback = null;
                     $data = null;

                     // add any default arguments
                     if (isset($_attributes)) {

                         if (!array_key_exists("class", $_attributes)) {
                             $_attributes["class"] = "form-control";
                         } else {
                             $_attributes["class"] .= "form-control";
                         }
                         if (array_key_exists("callback", $_attributes)) {
                             $callback = $_attributes['callback'];
                             unset($_attributes['callback']);
                         }

                         if (array_key_exists("data", $_attributes)) {

                             $data = (array) $_attributes['data'];

                             unset($_attributes['data']);
                         }
                     } else {
                         $_attributes = array();

                         $_attributes["class"] = "form-control";
                     }

                     $attrAsString = self::extractAttrs($_attributes);
                     ?>
                    <select name="<?php echo($_name) ?>" id="<?php echo($_id) ?>" <?php echo($attrAsString) ?> >
                     <?php
                     if ($callback) {
                         call_user_func($callback, $data, $_value);
                     } else {
                         if ($data && is_array($data)) {
                             _e("<option value=''></option>");
                             if (array_keys($data) != array_keys(array_keys($data))) {
                                 foreach ($data as $key => $value) {

                                     $selected = $value === $_value ? 'selected' : "";
                                     echo("<option value='" . $value . "' " . $selected . ">" . $key . "</option>");
                                 }
                             } else {
                                 foreach ($data as $value) {
                                     $selected = $value === $_value ? 'selected' : "";
                                     echo("<option value='" . $value . "' " . $selected . ">" . $value . "</option>");
                                 }
                             }
                         }
                     }
                     ?>
                    </select>

                    <?php
                    break;
                    case 'checkbox':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;

                        // add any default arguments
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= "form-control";
                            }
                            if (array_key_exists("callback", $_attributes)) {
                                $callback = $_attributes['callback'];
                                unset($_attributes['callback']);
                            }

                            if (array_key_exists("data", $_attributes)) {

                                $data = (array) $_attributes['data'];

                                unset($_attributes['data']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "form-control";
                        }

                        $attrAsString = self::extractAttrs($_attributes);

                        $checked = isset($callback) ? call_user_func($callback, $_value) : $_value != 0 ? "checked" : "";
                        ?>
                         <input type="checkbox" name="<?php echo($_name) ?>" 
                           value="<?php echo($_value) ?>" <?php _e($checked); ?> id='<?php _e($_id) ?>'>  

                   

                    <?php
                    break;
                    case 'multiple-checkbox':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;
                        $repeat = null;
                    

                        // add any default arguments
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= "form-control";
                            }
                            if (array_key_exists("callback", $_attributes)) {
                                $callback = $_attributes['callback'];
                                unset($_attributes['callback']);
                            }

                            if (array_key_exists("data", $_attributes)) {

                                $data = (array) $_attributes['data'];

                                unset($_attributes['data']);
                            }
                            if (array_key_exists("repeat", $_attributes)) {

                                $repeat =  $_attributes['repeat'];

                                unset($_attributes['repeat']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "form-control";
                        }
                    
                        $attrAsString = self::extractAttrs($_attributes);

                        $checked = isset($callback) ? call_user_func($callback, $_value) : $_value != 0 ? "checked" : "";
                        ?>
                     <?php 
                     if($repeat && is_array($repeat)){
                       
                         $multipleCheckBox = "";
                         foreach ($repeat as $currentField):
                          $multipleCheckBox .= " ".$currentField.' <input type="checkbox" name="'.$_name .'[]"'.
                           ' value="'.$currentField.'" >';
                         endforeach;
                         echo $multipleCheckBox;
                     }else{
                         ?>
                      
                    <input type="checkbox" name="<?php echo($_name) ?>" 
                           value="<?php echo($_value) ?>" <?php _e($checked); ?> >  

                      <?php
                     }
                   
                     ?>
                  

                    <?php
                    break;
                    case 'datalist':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;

                        // add any default arguments
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= " form-control";
                            }
                            if (array_key_exists("callback", $_attributes)) {
                                $callback = $_attributes['callback'];
                                unset($_attributes['callback']);
                            }

                            if (array_key_exists("data", $_attributes)) {

                                $data = (array) $_attributes['data'];

                                unset($_attributes['data']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "form-control";
                        }

                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                        <input name="<?php echo($_name) ?>" list="<?php echo($_name) ?>" <?php _e($attrAsString) ?>>
                        <datalist id="<?php echo($_name) ?>">
                        <?php
                        if ($callback) {

                            call_user_func($callback, $data, $_value);
                        } else {
                            if ($data && is_array($data)) {
                                _e("<option value=''></option>");
                                if (array_keys($data) != array_keys(array_keys($data))) {
                                    foreach ($data as $key => $value) {

                                        $selected = $value === $_value ? 'selected' : "";
                                        echo("<option value='" . $value . "' " . $selected . ">" . $key . "</option>");
                                    }
                                } else {
                                    foreach ($data as $value) {
                                        $selected = $value === $_value ? 'selected' : "";
                                        echo("<option value='" . $value . "' " . $selected . ">" . $value . "</option>");
                                    }
                                }
                            }
                        }
                        ?>
                        </datalist>


                            <?php
                            break;
                    case 'tagbox':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;

                        // add any default arguments
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= " form-control";
                            }
                            if (array_key_exists("callback", $_attributes)) {
                                $callback = $_attributes['callback'];
                                unset($_attributes['callback']);
                            }

                            if (array_key_exists("data", $_attributes)) {
                                $data = $_attributes['data'];
                                unset($_attributes['data']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "form-control";
                        }
                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                    <!--                                note : for the tag to work it requires javascript attached to the class
                                                    e.g  $(".recipient-tokenizer").select2({
                                                    tags: true,
                                                    tokenSeparators: [',', ' ']
                                                        })-->
                    <select name="<?php echo($_name) ?>" multiple="" id="<?php echo($_id) ?>" <?php echo($attrAsString) ?> >
                    <?php
                    if ($callback) {
                        call_user_func($callback, $data, $_value);
                    } else {
                        if ($data && is_array($data)) {
                            if (array_keys($data) != array_keys(array_keys($data))) {
                                foreach ($data as $key => $value) {
                                    $selected = $value === $_value ? 'selected' : "";
                                    echo("<option value='" . $value . "' " . $selected . ">" . $key . "</option>");
                                }
                            } else {
                                foreach ($data as $value) {
                                    $selected = $value === $_value ? 'selected' : "";
                                    echo("<option value='" . $value . "' " . $selected . ">" . $value . "</option>");
                                }
                            }
                        }
                    }
                    ?>
                    </select>

                    <?php
                    break;
                    case 'fieldlist':
                    $attrAsString = "";
                    $callback = null;
                    $data = null;

                    // add any default arguments
                    if (isset($_attributes)) {
                    if (!array_key_exists("size", $_attributes)) {
                        $_attributes["size"] = 50;
                    }
                    if (!array_key_exists("class", $_attributes)) {
                        $_attributes["class"] = "form-control";
                    } else {
                        $_attributes["class"] .= "form-control";
                    }


                    if (array_key_exists("data", $_attributes)) {
                        $data = $_attributes['data'];
                        unset($_attributes['data']);
                    }
                    } else {
                    $_attributes = array();

                    $_attributes["class"] = "form-control";
                    }

                    $attrAsString = self::extractAttrs($_attributes);
                    $keyname = "key" . rand(1000, 10000);
                    $valuename = "value" . rand(1000, 10000);
                    ?>
                        <div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="<?php _e($keyname) ?>">Key</label>
                                    <input class="form-control" text="text" id="<?php _e($keyname) ?>">
                                </div>
                                <div class="col-sm-5"><label for="<?php _e($valuename) ?>">Value</label>
                                    <input class="form-control" text="text" id="<?php _e($valuename) ?>"></div>     
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <br><button type="button" id="<?php _e($keyname . "add") ?>" keyVal="<?php _e($keyname . "|" . $valuename . "|" . $_name) ?>"   class="btn btn-small btn-default fieldlistAddBtn">Add</button>
                                </div>
                            </div>
                        <?php
                        if ($_value) {
                            $index = 0;
                            $class_prefix = rand(1000, 4000);
                            $_value = !is_array($_value) ? unserialize($_value) : $_value;
                            foreach ($_value as $key => $value):
                                ?>
                                    <div class="row field <?php _e($class_prefix . $index) ?>">
                                        <div class="col-sm-5"><input value="<?php echo($key) ?>" readonly=""  <?php echo($attrAsString) ?> ></div>

                                        <div class="col-sm-5"><input value="<?php
                                if (is_array($value)) {
                                    echo(implode(",", $value));
                                } else {
                                    echo($value);
                                }
                                ?>" name="<?php echo($_name . "[$key]") ?>" <?php echo($attrAsString) ?> ></div>
                                        <div class="col-sm-2">
                                            <button type="button"   containerClassName="<?php _e($class_prefix . $index) ?>"  class="btn btn-small field-remove-btn btn-danger">&nbsp; - &nbsp;</button>
                                        </div>

                                    </div>
                        <?php
                    endforeach;
                    ?>
                            </div>
                    <?php
                    }
                    ?>
                            <?php
                            break;
                    case 'datetime':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;

                        // add any default arguments
                        if (isset($_attributes)) {

                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "dtTmPicker";
                            } else {
                                $_attributes["class"] .= " dtTmPicker";
                            }


                            if (array_key_exists("data", $_attributes)) {
                                $data = $_attributes['data'];
                                unset($_attributes['data']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "dtTmPicker";
                        }

                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                    <!--                     -->
                    <div class="well">
                        <div class="form-group">
                            <div id="<?php echo($_id) ?>" class="input-append input-group date datetimepicker">
                                <input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" value="<?php echo($_value); ?>" id="enddate" name="<?php echo($_name); ?>" value="">
                                <span class="add-on input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                    case "image":
                    $imageSize = "thumbnail";
                    $buttonLabel = "Upload Image";

                        if (isset($_attributes)) {
                            
                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "form-control";
                            } else {
                                $_attributes["class"] .= " form-control";
                            }
                             if (array_key_exists("size", $_attributes)) {
                               // $imageSize = $_attributes["size"];
                                unset($_attributes['size']);
                          }
                        if(array_key_exists("button-label", $_attributes)){
                            $buttonLabel = $_attributes['button-label'];
                             unset($_attributes['button-label']);
                        }
                        } else {
                            $_attributes = array();
                            $_attributes["size"] = 50;
                            $_attributes["class"] = "form-control";
                            $_attributes["placeholder"] = $_name;
                        }
                        $attrAsString = self::extractAttrs($_attributes);
                        if ($_value) {

                            $existing_image_id = $_value;
                            if (is_numeric($existing_image_id)) {
                                echo '<div>';
                                $arr_existing_image = wp_get_attachment_image_src($existing_image_id,$imageSize);
                                $existing_image_url = $arr_existing_image[0];
                                echo '<img src="' . $existing_image_url . '"  />';
                                echo '</div>';
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <input id="<?php echo($_id) ?>" 
                                       name="<?php echo($_name); ?>" 
                                       type="text"  readonly=""
                                       value="<?php echo($_value); ?>"
                        <?php echo($attrAsString); ?>
                                       > 
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <input id="upload-button" type="button" class="btn btn-primary" input-name="<?php _e($_name) ?>" value="<?php _e($buttonLabel) ?>" />
                            </div>
                        </div>  
                        <?php
                        break;
                    case 'time':
                        $attrAsString = "";
                        $callback = null;
                        $data = null;

                        // add any default arguments
                        if (isset($_attributes)) {
                     
                            if (!array_key_exists("class", $_attributes)) {
                                $_attributes["class"] = "dtTmPicker";
                            } else {
                                $_attributes["class"] .= " dtTmPicker";
                            }


                            if (array_key_exists("data", $_attributes)) {
                                $data = $_attributes['data'];
                                unset($_attributes['data']);
                            }
                        } else {
                            $_attributes = array();

                            $_attributes["class"] = "dtTmPicker";
                        }

                        $attrAsString = self::extractAttrs($_attributes);
                        ?>
                        <!--                     -->
                        <div class="well">
                            <div class="form-group">
                                <div id="<?php echo($_id) ?>" class="input-append input-group date datetimepicker">
                                    <input   type="time" class="form-control" value="<?php echo($_value); ?>"   name="<?php echo($_name); ?>" value="">
                                    <span class="add-on input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                }
                ?>
            </td>
        </tr>
                <?php
            }

            static function getCheckBox() {
                
            }

        }
        