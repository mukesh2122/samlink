<?php

class ContentHelper {

    /**
     * @author jvs
     * Adds extrafields to EditorData
     */
    public static function AddEditorDataExtrafields($extrafields, $EditorData, $that) {
        //Add extrafields to EditorData
        if (isset($extrafields)) {
            foreach ($extrafields as $extrafield) {
                $et = $extrafield['FieldType'];
                $type = "text";
                if ($et == "boolean")
                    $type = "checkbox";
                if ($et == "date")
                    $type = "date";

                $a = array(
                    'type' => $type,
                    'title' => $extrafield['FieldName'],
                    'value' => $extrafield['ValueText'],
                    'id' => "extrafield_" . $extrafield['ID_FIELD'],
                    'CbVisibile' => '1'
                );

                if ($type == "checkbox") {
                    $a = array(
                        'type' => $type,
                        'title' => $extrafield['FieldName'],
                        'id' => "extrafield_" . $extrafield['ID_FIELD'],
                        'label' => $that->__('Yes'),
                        'checked' => $extrafield['ValueBoolean'] == 1,
                        'CbVisibile' => '1'
                    );
                }

                if ($type == "date") {
                    $a = array(
                        'type' => $type,
                        'title' => $extrafield['FieldName'],
                        'id' => "extrafield_" . $extrafield['ID_FIELD'] . "",
                        'prefix' => "extrafield_" . $extrafield['ID_FIELD'] . "_",
                        'label' => $that->__('Yes'),
                        'value' => $extrafield['ValueDate'],
                        'CbVisibile' => '1'
                    );
                }

                $EditorData['Elements'][] = $a;
            }
        }
        return $EditorData;
    }

    /**
     * @author jvs
     * Adds categoryfield to EditorData
     */
    public static function AddEditorDataCategories($categories, $EditorData, $that, $ID_PLAYER, $adminMode) {
        $selected_category = MainHelper::GetPlayersCategory($ID_PLAYER);
        $WhoApprovedMe = MainHelper::WhoApprovedMe($ID_PLAYER);

        $catOptions = array();
        $catOptions[] = array
            (
            'text' => $that->__('Select category'),
            'selected' => '',
            'value' => '0',
        );
        foreach ($categories as $cat) {
            $catOptions[] = array
                (
                'text' => $cat['CategoryName'],
                'selected' => ($cat['ID_CATEGORY'] == $selected_category),
                'value' => $cat['ID_CATEGORY']
            );
        }

        $ApprovedBy = ($WhoApprovedMe != null) ? '(' . $that->__('Approved by ') . $WhoApprovedMe['NickName'] . ')' : '';

        $a = array(
            'type' => 'select',
            'id' => 'playercategory',
            'name' => 'playercategory',
            'title' => $that->__('Category') . ((!$adminMode) ? "<br/>" . $ApprovedBy : ''),
            'options' => $catOptions,
            'link' => '',
            'CbVisibile' => '1'
        );

        $EditorData['Elements'][] = $a;

        if ($adminMode) {
            $a = array(
                'type' => 'linklabel',
                'id' => 'approvedby',
                'name' => 'approvedby',
                'title' => $that->__('Approved by'),
                'value' => $WhoApprovedMe['NickName'],
                'link' => 'admin/users/edit/' . $WhoApprovedMe['ID_PLAYER']
            );

            $EditorData['Elements'][] = $a;
        }
        return $EditorData;
    }

    /**
     * @author ungamed
     * Simplifies the creation of an option for a selectbox, by providing defaults and eliminates key misspells
     */
    public static function CreateEditorOption($text, $value = '', $selected = false) {
        return array(
            'value' => $value,
            'selected' => $selected,
            'text' => $text
        );
    }

    /**
     * @author ungamed
     * Converts an array of objects to html options
     * the option will be checked if $CheckOption exists in $inAry
     *
     * @param mixed The object array
     * @param string The name of the key that contains the value
     * @param string The name of the key that contains the title
     * @param string the string, that if exists in $inAry, sets the option as checked
     * @param mixed $inAry The array of checked items
     */
    public static function ObjArrayToOptions($Source, $ValueKey, $TitleKey, $CheckOption, $inAry) {
        $result = array();
        foreach ($Source as $Option) {
            $result[] = array(
                'value' => $Option->$ValueKey,
                'text' => $Option->$TitleKey,
                'selected' => in_array($Option->$CheckOption, $inAry)
            );
        }
        return $result;
    }

    /**
     * @author ungamed
     * Parses an array to display a edit page
     *
     * @param array $EditorData
     */
    public static function ParseEditorData($EditorData) {
        $Tabindex = 1;
        $Classes = isset($EditorData['class']) ? (' ' . $EditorData['class']) : '';
        $Submitbutton = isset($EditorData['Submitbutton']) ? $EditorData['Submitbutton'] : 'Save Settings';
        if (isset($EditorData['formid'])) {
            echo '<form class="standard_form', $Classes, '" id="', $EditorData['formid'], '" method="post" action="', $EditorData['Post'], '" enctype="multipart/form-data">';
        } else {
            echo '<form class="standard_form', $Classes, '" method="post" action="', $EditorData['Post'], '" enctype="multipart/form-data">';
        };
        echo '<div class="standard_form_elements clearfix">';

        if (isset($EditorData['PersonalInformation'])) {
            $PersonalInformation = $EditorData['PersonalInformation'];
        };

        $Elements = $EditorData['Elements'];
        foreach ($Elements as $Element) {
            if (empty($Element))
                break;
            echo '<div class="clearfix">'; // create a overall wrapper to enable extra stuff

            $Element['type'] = isset($Element['type']) ? $Element['type'] : 'text';

            $isEnabled = true;
            //Test if this field is enabled
            $NativeFields = isset($EditorData['NativeFields']) ? $EditorData['NativeFields'] : array();
            if (isset($NativeFields)) {
                if (isset($Element['fieldName'])) {
                    foreach ($NativeFields as $nativeField) {
                        if ($nativeField['FieldName'] == $Element['fieldName']) {
                            if ($nativeField['isEnabled'] == 0) {
                                $isEnabled = false;
                            };
                        };
                    };
                };
            };

            if ($isEnabled) {
                $cbID = '';
                $cbName = '';
                if (isset($Element['id'])) {
                    $cbID = 'vcb_' . $Element['id'];
                };
                if (isset($Element['name'])) {
                    $cbName = 'vcb_' . $Element['name'];
                } else {
                    $cbName = $cbID;
                };

                $cbChecked = '';
                $visibleCb = '';

                if (isset($PersonalInformation)) {
                    if (isset($Element['CbVisibile'])) {
                        if ($Element['CbVisibile'] == 1) {
                            if (in_array($cbName, $PersonalInformation)) {
                                $cbChecked = 'checked="checked"';
                            };
                        };
                    };
                    $pos = isset($Element['CbVisibileLeft']) ? $Element['CbVisibileLeft'] : '100%';
                    $visibleCb = '<div style="position:relative;top:-40px;left:' . $pos . ';">' .
                            (isset($Element['CbVisibile']) ?
                                    ( ($Element['CbVisibile'] == 1) ?
                                            '<input id="' . $cbID . '" name="' . $cbName . '" class="dst" type="checkbox" value="1" ' . $cbChecked . '">' :
                                            '<input class="dst" type="checkbox" value="1" checked="checked" disabled="disabled">'
                                    ) : '') .
                            '</div><br/>';
                }

                //Personal information echo'<input class="dst" type="checkbox" value="1" checked="checked"/>';
                switch ($Element['type']) {
                    case 'titleex': // Extended title with info
                        echo '<div class="standard_form_header clearfix">';
                        echo '<h1 class="pull_left">' . $Element['text'] . '</h1>';
                        echo '<span class="pull_right standard_form_header_info">' . $Element['info'] . '</span>';
                        echo '</div>';
                        break;
                    case 'jslink':
                        $class = isset($Element['class']) ? $Element['class'] : '';
                        echo '<a href="javascript:void(0);" class="fl ' . $class . '">' . $Element['text'] . '</a>';
                        break;
                    case 'jslinklabel':
                        echo '<div class="standard_form_checks clearfix">';
                        echo '<label>' . $Element['title'] . '</label>';
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        echo '<div>';
                        $rel = isset($Element['rel']) ? $Element['rel'] : '';
                        $class = isset($Element['class']) ? $Element['class'] : '';
                        echo '<a rel="' . $rel . '" href="javascript:void(0);" class="fl ' . $class . '">' . $Element['text'] . '</a>';
                        echo '</div>';
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        break;
                    case 'title':
                        $class = isset($Element['class']) ? $Element['class'] : '';
                        echo '<div class="standard_form_header ' . $class . ' clearfix">';
                        echo '<h1 class="pull_left">' . $Element['text'] . '</h1>';
                        echo '</div>';
                        break;
                    case 'customboxes':
                        echo '<div class="standard_form_checks clearfix">';
                        echo '<label>' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        foreach ($Element['options'] as $option) {
                            $action = isset($option['action']) ? $option['action'] : '';

                            echo '<input ' . $action . ' tabindex="' . ($Tabindex++) . '" class="' . $option['class'] . '" type="checkbox" id="' . $option['id'] . '" name="' . $option['name'] . '" value="' . $option['value'] . '" ' . ($option['selected'] ? 'checked="checked"' : '') . '>';
                            echo '<label style="width: 100px;" for="' . $option['id'] . '">' . $option['text'] . '</label>';
                        }
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'checkboxes':
                        echo '<div class="standard_form_checks clearfix">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        foreach ($Element['options'] as $option) {
                            echo '<input tabindex="' . ($Tabindex++) . '" class="dst" type="checkbox" id="dst' . $option['value'] . '" name="' . $Element['id'] . '[]" value="' . $option['value'] . '" ' . ($option['selected'] ? 'checked="checked"' : '') . '>';
                            echo '<label style="width: 100px;" for="dst' . $option['value'] . '">' . $option['text'] . '</label>';
                        }
                        echo '</div>';
//						echo '</span>';
						echo '</div>';
						echo $visibleCb;
						break;
					case 'textfield':
						echo '<div class="clearfix standard_form_elements">',
                            '<p><label for="', $Element['id'], '">', $Element['text'], '</label></p><br/>';
						if(isset($Element['tooltip'])) {
							echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>',
                                '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>', $Element['tooltip'], '</div>';
						};
                        if(!isset($Element['maxlen'])) { $Element['maxlen'] = "32767"; };
                        if(!isset($Element['toolbar'])) { $Element['toolbar'] = ""; };
						echo '<div class="border mt2">', MainHelper::loadCKE($Element['id'], $Element['value'], array("removePlugins" => "resize", "extraPlugins" => "autogrow,maxlength"), array("textareaAttributes" => array("maxlength" => $Element['maxlen'])), array(), $Element['toolbar']), '</div>', '</div>', $visibleCb;
						break;
					case 'checkbox':
						echo '<div class="standard_form_checks clearfix">';
						echo '<label for="', $Element['id'], '">', $Element['title'], '</label>';
						if(isset($Element['tooltip'])) {
							echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
							echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>', $Element['tooltip'], '</div>';
						};
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        echo '<input tabindex="', ($Tabindex++), '" class="dst" type="checkbox" id="', $Element['id'], '" name="', (isset($Element['name']) ? $Element['name'] : $Element['id']), '" value="1" ', ($Element['checked'] ? 'checked="checked"' : ''), '>';
                        echo '<label for="', $Element['id'], '">', (isset($Element['label']) ? $Element['label'] : ''), '</label>';
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'info':
                        echo '<div class="standard_form_info_header">';
                        echo '<h2>' . $Element['value'] . '</h2>';
                        if (isset($Element['info'])) {
                            echo '<p>' . $Element['info'] . '</p>';
                        }
                        echo '</div>';
                        break;
                    case 'columnlabel':
                        echo '<div class="standard_form_checks clearfix">';
                        echo '<label>' . $Element['title'] . '</label>';
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        foreach ($Element['options'] as $option) {
                            $current = ($option['current']) ? 'current' : '';
                            echo '<div style="' . $option['style'] . '">';
                            echo '<a href="' . MainHelper::site_url('players/edit/widgets/sort-by/' . $option['link']) . '" class="column-label ' . $current . '" title="Sort by ' . strtolower($option['text']) . '">' . $option['text'] . '</a> ';
                            if (isset($option['tooltip'])) {
                                echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                                echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $option['tooltip'] . '</div>';
                            }
                            echo '</div>';
                        }
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        break;
                    case 'password':
                    case 'text':
                        echo '<div class="clearfix">';
                        if (!isset($Element['name'])) {
                            $Element['name'] = $Element['id'];
                        };
                        if (!isset($Element['value'])) {
                            $Element['value'] = '';
                        };
                        if (!isset($Element['maxlen'])) {
                            $Element['maxlen'] = 1000;
                        };
                        echo '<label for="', $Element['name'], '">', $Element['title'], '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>',
                            '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>', $Element['tooltip'], '</div>';
                        };
                        $class = isset($Element['class']) ? (' class="' . $Element['class'] . '"') : '';
                        echo '<span', $class, '>',
                        '<input tabindex="', ($Tabindex++), '" id="', $Element['id'], '" name="', $Element['name'], '" type="', $Element['type'], '" value="', $Element['value'], '" class="text_input" maxlength="', $Element['maxlen'], '">',
                        '</span>';
                        /*
                          if(isset($Element['error'])) {
                          echo '<div id="', $Element['name'], '-error" class="error">',
                          '<label for="', $Element['name'], '" class="error" generated="true"></label>',
                          '</div>';
                          };
                         */
                        echo '</div>', $visibleCb;
                        break;
                    case 'linklabel':
                        echo '<div class="standard_form_checks clearfix">';
                        echo $visibleCb . '<label>' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        $rel = (isset($Element['rel'])) ? ' rel="' . $Element['rel'] . '"' : '';
                        $class = (isset($Element['class'])) ? ' class="' . $Element['class'] . '"' : '';
                        echo '<div><a' . $rel . $class . ' href="' . MainHelper::site_url($Element['link']) . '">' . $Element['value'] . '</a></div>';
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        break;
                    case 'desc':
                        echo '<div class="clearfix">';
                        if (!isset($Element['name']))
                            $Element['name'] = $Element['id'];
                        if (!isset($Element['value']))
                            $Element['value'] = '';
                        echo '<label for="' . $Element['name'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        echo '<div class="standard_form_checks_wrapper no-margin clearfix">';
                        echo '<textarea rows="7" cols="43" tabindex="' . ($Tabindex++) . '" id="' . $Element['id'] . '" name="' . $Element['name'] . '">' . $Element['value'] . '</textarea>';
                        echo '</div>';
//						echo '</span>';
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'date':
                        echo '<div class="standard_form_dob clearfix">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        echo '<select id="' . $Element['id'] . 'Year" class="dropkick_lightNarrow" name="' . $Element['prefix'] . 'year" tabindex="' . ($Tabindex++) . '">';
                        $years = MainHelper::getYears();
                        foreach ($years as $c => $v) {
                            echo '<option value="' . $c . '" ' . ((MainHelper::isYearSelected($Element['value'], $v)) ? 'selected="selected"' : '') . '>';
                            echo $v;
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
//						echo '<span>';
                        echo '<select id="' . $Element['id'] . 'Month" class="dropkick_lightNarrow" name="' . $Element['prefix'] . 'month" tabindex="' . ($Tabindex++) . '">';
                        $months = MainHelper::getMonthList();
                        foreach ($months as $c => $v) {
                            echo '<option value="' . $c . '" ' . ((MainHelper::isMonthSelected($Element['value'], $c)) ? 'selected="selected"' : '') . '>';
                            echo $v;
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
//						echo '<span>';
                        echo '<select id="' . $Element['id'] . 'Day" class="dropkick_lightNarrow" name="' . $Element['prefix'] . 'day" tabindex="' . ($Tabindex++) . '">';
                        $days = MainHelper::getDays();
                        foreach ($days as $c => $v) {
                            echo '<option value="' . $c . '" ' . ((MainHelper::isDaySelected($Element['value'], $v)) ? 'selected="selected"' : '') . '>';
                            echo $v;
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
                        if (isset($Element['error'])) {
                            echo '<div id="' . $Element['id'] . '-error" class="error">';
                            echo '<label for="' . $Element['id'] . '" class="error" generated="true"></label>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'time':
                        echo '<div class="standard_form_dob clearfix">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
//						echo '<span>';
                        echo '<select id="' . $Element['id'] . 'Minutes" class="dropkick_lightNarrow" name="' . $Element['prefix'] . 'minutes" tabindex="' . ($Tabindex++) . '">';
                        $minutes = MainHelper::getMinutes();

                        foreach ($minutes as $v) {
                            //$min = $v == 'Min' ? '00' : $v;
                            echo '<option value="' . $v . '" ' . ((MainHelper::isMinuteSelected($Element['value'], $v)) ? 'selected="selected"' : '') . '>';
                            echo $v;
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
                        echo '<select id="' . $Element['id'] . 'Hour" class="dropkick_lightNarrow" name="' . $Element['prefix'] . 'hours" tabindex="' . ($Tabindex++) . '">';
                        $hours = MainHelper::getHours();
                        foreach ($hours as $v) {
                            //$hour = $v == 'Hour' ? '00' : $v;
                            echo '<option name="' . $Element['value'] . '" value="' . $v . '" ' . ((MainHelper::isHourSelected($Element['value'], $v)) ? 'selected="selected"' : '') . '>';
                            echo $v;
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';

                        if (isset($Element['error'])) {
                            echo '<div id="' . $Element['id'] . '-error" class="error">';
                            echo '<label for="' . $Element['id'] . '" class="error" generated="true"></label>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'select':
                        $divstyle = (isset($Element['divstyle'])) ? $Element['divstyle'] : '';
                        $divid = (isset($Element['divid'])) ? $Element['divid'] : '';
                        echo '<div id="' . $divid . '" class="clearfix" style="' . $divstyle . '">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        $class = (isset($Element['class'])) ? $Element['class'] : '';
                        echo '<select id="' . $Element['id'] . '" class="' . $class . ' dropkick_lightWide" name="' . (isset($Element['name']) ? $Element['name'] : $Element['id']) . '" tabindex="' . ($Tabindex++) . '">';
                        if (isset($Element['value'])) {
                            echo '<option value="' . $Element['value'] . '">';
                            echo $Element['text'];
                            echo '</option>';
                        }
                        foreach ($Element['options'] as $option) {
                            echo '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected="selected"' : '') . '>';
                            echo $option['text'];
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
                        if (isset($Element['error'])) {
                            echo '<div id="' . $Element['id'] . '-error" class="error">';
                            echo '<label for="' . $Element['id'] . '" class="error" generated="true"></label>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'selectNarrow':
                        $divstyle = (isset($Element['divstyle'])) ? $Element['divstyle'] : '';
                        $divid = (isset($Element['divid'])) ? $Element['divid'] : '';
                        echo '<div id="' . $divid . '" class="clearfix" style="' . $divstyle . '">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
//						echo '<span>';
                        $class = (isset($Element['class'])) ? $Element['class'] : '';
                        echo '<select id="' . $Element['id'] . '" class="dropkick_lightNarrow ' . $class . '" name="' . (isset($Element['name']) ? $Element['name'] : $Element['id']) . '" tabindex="' . ($Tabindex++) . '">';
                        if (isset($Element['value'])) {
                            echo '<option value="' . $Element['value'] . '">';
                            echo $Element['text'];
                            echo '</option>';
                        }
                        foreach ($Element['options'] as $option) {
                            echo '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected="selected"' : '') . '>';
                            echo $option['text'];
                            echo '</option>';
                        }
                        echo '</select>';
//						echo '</span>';
                        if (isset($Element['error'])) {
                            echo '<div id="' . $Element['id'] . '-error" class="error">';
                            echo '<label for="' . $Element['id'] . '" class="error" generated="true"></label>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'list':
                        $divstyle = (isset($Element['divstyle'])) ? $Element['divstyle'] : '';
                        $divid = (isset($Element['divid'])) ? $Element['divid'] : '';
                        echo '<div id="' . $divid . '" class="clearfix" style="' . $divstyle . '">';
                        echo '<label for="' . $Element['id'] . '">' . $Element['title'] . '</label>';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
                        echo '<div class="di select_list">';
//						echo '<span class="select_list">';
												$class = (isset($Element['class'])) ? $Element['class']: '';
												$size = isset($Element['size']) ? $Element['size'] : '5';
												$height = isset($Element['height']) ? $Element['height'] : '100px';
						echo '<select size="'.$size.'" style="height:'.$height.'" multiple="yes" id="'.$Element['id'].'" class="'.$class.' select_list_lightWide" name="'.(isset($Element['name'])?$Element['name']:$Element['id']).'" tabindex="'.($Tabindex++).'">';
						if (isset($Element['value']))
						{
							echo '<option value="'.$Element['value'].'">';
							echo $Element['text'];
							echo '</option>';
						}
						foreach ($Element['options'] as $option)
						{
							echo '<option value="'.$option['value'].'" '.($option['selected'] ? 'selected="selected"' : '').'>';
							echo $option['text'];
							echo '</option>';
						}
						echo '</select>';
						echo '</div>';
//						echo '</span>';
                        if (isset($Element['error'])) {
                            echo '<div id="' . $Element['id'] . '-error" class="error">';
                            echo '<label for="' . $Element['id'] . '" class="error" generated="true"></label>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo $visibleCb;
                        break;
                    case 'button':
                        $divstyle = (isset($Element['divstyle'])) ? $Element['divstyle'] : '';
                        $class = (isset($Element['class'])) ? $Element['class'] : '';
                        echo '<div class="clearfix ' . $class . '" style="' . $divstyle . '">';
                        if (isset($Element['tooltip'])) {
                            echo '<a href="javascript:void(0);" class="tooltipHelper">(?)</a>';
                            echo '<div class="tooltipHelperBox"><span class="tooltipHelperBoxTop"></span>' . $Element['tooltip'] . '</div>';
                        }
                        echo '<div class="border mt2">';
                        echo '<input tabindex="' . ($Tabindex++) . '" id="' . $Element['id'] . '" type="button" value="' . $Element['value'] . '" class="button button_medium light_grey pb3">';
                        echo '</div>';
                        echo '</div>';
                        break;
                    case 'picture':
                        if (isset($Element['show']) && $Element['show'] == 'hide') {
                            break;
                        }
                        $SnImages = Doo::db()->getOne('SnImages', array(
                            'limit' => 1,
                            'where' => 'ID_OWNER = ? AND OwnerType = "' . $EditorData['ID_PRE'] . '"',
                            'param' => array($EditorData['ID'])
                        ));
                        if (!is_object($SnImages)) {
                            ?>
                            <div class="standard_form_info_header">
                                <h2><?php echo SnController::__($EditorData['Title'] . ' photo') ?></h2>
                                <p><?php echo SnController::__('Change ' . strtolower($EditorData['Title']) . ' photo. Use PNG, GIF or JPG.'); ?></p>
                            </div>
                            <div class="profile_foto_edit clearfix">
                                <label><?php echo SnController::__($EditorData['Title'] . ' photo'); ?></label>
                                <div class="standard_form_photo clearfix">
                                    <div class="standard_form_photo_wrapper">
                            <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                    </div>
                                    <div class="standard_form_photo_action">
                                        <a id="change_<?php echo $EditorData['ID_PRE']; ?>_picture" rel="<?php echo $EditorData['ID']; ?>" class="button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clearfix">
                            <label><?php echo $EditorData['Title'] . ' square photo'; ?></label>
                            <div class="standard_form_photo clearfix">
                                <div id="picture_crop_square" class="standard_form_photo_wrapper">
                        <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                </div>
                                <div class="standard_form_photo_action">
                                    <a id="change_picture_crop_square" rel="<?php echo $EditorData['ID']; ?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="square" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php SnController::__('Upload Photo'); ?></a>
                                    <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                            <label><?php echo SnController::__($EditorData['Title'] . ' portrait photo'); ?></label>
                            <div class="standard_form_photo clearfix">
                                <div id="picture_crop_portrait" class="standard_form_photo_wrapper">
                        <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x150, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                </div>
                                <div class="standard_form_photo_action">
                                    <a id="change_picture_crop_portrait" rel="<?php echo $EditorData['ID']; ?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="portrait" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php SnController::__('Upload Photo'); ?></a>
                                    <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label><?php echo SnController::__($EditorData['Title'] . ' landscape photo'); ?></label>
                            <div class="standard_form_photo clearfix">
                                <div id="picture_crop_landscape" class="standard_form_photo_wrapper">
                                    <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x75, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                </div>
                                <div class="standard_form_photo_action">
                                    <a id="change_picture_crop_landscape" rel="<?php echo $EditorData['ID']; ?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="landscape" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                                    <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label><?php echo SnController::__($EditorData['Title'] . ' banner photo'); ?></label>
                            <div class="standard_form_photo clearfix">
                                <div id="picture_crop_banner" class="standard_form_photo_wrapper">
                                    <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x33, false, array('width', 'no_img' => 'noimage/no_game_100x33.png')); ?>
                                </div>
                                <div class="standard_form_photo_action">
                                    <a id="change_picture_crop_banner" rel="<?php echo $EditorData['ID']; ?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="banner" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                                    <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                                </div>
                            </div>
                        </div><?php
                                    break;
                                case 'screenshot':
                                    $Table = isset($Element['table']) ? $Element['table'] : 'SnImages';
                                    $IdColumnName = isset($Element['name']) ? $Element['name'] : 'ID_OWNER';
                                    $UrlImage = isset($Element['link']) ? $Element['link'] : '';

                                    $SnImages = Doo::db()->getOne($Table, array(
                                        'limit' => 1,
                                        'where' => $IdColumnName . ' = ? ',
                                        'param' => array($EditorData['ID'])
                                    ));
                                    ?>
                        <div class="profile_foto_edit clearfix">
                            <label><?php echo $Element['title']; ?></label>
                            <div class="standard_form_photo mt2">
                                <div class="standard_form_photo_wrapper">
                                    <a href="<?php echo MainHelper::site_url($UrlImage . $EditorData['ID'] . '/image'); ?>" rel="photo_tag"><?php echo MainHelper::showImage($SnImages, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_forum_100x100.png')); ?>
                                    </a>
                                </div>
                        <?php if ($SnImages->ImageURL != '') { ?>								
                                    <div class="standard_form_photo_action">
                                        <a id="change_<?php echo $EditorData['ID_PRE']; ?>_screenshot" rel="<?php echo $SnImages->ID_ERROR; ?>" class="button button_medium light_grey" href="javascript:void(0)"><?php echo SnController::__('Upload screenshot'); ?></a>
                                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                            <?php if (isset($Element['info'])) {
                                echo "<p>" . $Element['info'] . "</p>";
                            } ?>
                                    </div>
                        <?php } else { ?>
                                    <div class="standard_form_photo_action">
                                        <a id="add_<?php echo $EditorData['ID_PRE']; ?>_screenshot" rel="<?php echo $SnImages->ID_ERROR; ?>" class="button button_medium light_grey" href="javascript:void(0)"><?php echo SnController::__('Upload screenshot'); ?></a>
                                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                            <?php if (isset($Element['info'])) {
                                echo "<p>" . $Element['info'] . "</p>";
                            } ?>
                                    </div>
                        <?php } ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'fileupload': /* ?>
                          <?php */
                        $model = '';

                        switch ($EditorData['ID_PRE']) {
                            case 'level':
                                $achievements = new Achievement();
                                $model = $achievements->getLevelByID($EditorData['ID']);
                                break;
                            case 'achievement':
                                $achievements = new Achievement();
                                $model = $achievements->getAchievementByID($EditorData['ID']);
                                break;
                            case 'cup':
                                break;
                            default:
                                break;
                        }

                        isset($Element['model']) && !empty($Element['model']) ? $model = $Element['model'] : '';
                        ?>
                        <div class="profile_foto_edit mt5">
                            <input type="hidden" id="imageName" name="<?php echo $Element['id']; ?>" value="">
                            <label><?php echo isset($Element['title']) ? $Element['title'] : SnController::__('Image'); ?></label>
                            <div class="standard_form_photo mt2">
                        <?php $preview = isset($Element['preview']) ? $Element['preview'] : true; ?>
                        <?php if ($preview): ?>
                                    <div class="standard_form_photo_wrapper">
                            <?php echo MainHelper::showImage($model, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                    </div>
                        <?php endif; ?>
                                <div class="standard_form_photo_action <?php echo $preview ? '' : 'ml0' ?>">
                                    <a id="<?php echo $Element['id']; ?>" rel="<?php echo $EditorData['ID']; ?>" class="button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                                    <p><?php echo $preview ? SnController::__('Use PNG, GIF or JPG.') : ''; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'roster':
                        ?>
                        <div class="clearfix">
                            <label><?php echo isset($Element['title']) ? $Element['title'] : SnController::__('Image'); ?></label>
                            <div id="roster" class="di pull_right w370">
                                <p id="fail" style="display:none"><?php echo SnController::__('player not found'); ?></p>
                                <div id="loader" class="pull_left loader_grey_small mt7" style="display:none"></div>
                                <a class="button button_medium light_grey pull_right" id="add"><?php echo SnController::__('Add'); ?></a>
                                <input type="text" class="text_input w200 pull_right mr8" id="email" value="Email">
                                <table class="table table_bordered table_striped gradient_thead mt10 mb10" id="list">
                                    <thead>
                                        <tr>
                                            <th class="size_35"><?php echo SnController::__('Name'); ?></th>
                                            <th class="size 45"><?php echo SnController::__('Email'); ?></th>
                                            <th class="size_10 centered"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php
                        if (!empty($Element['captain']) && isset($Element['captain'])):
                            echo '<tr>';
                            echo '<td>' . $Element['captain']->DisplayName . '</td>';
                            echo '<td>' . $Element['captain']->EMail . '</td>';
                            echo '<td><strong>C</strong></td>';
                            echo '</tr>';
                        endif;

                        if (!empty($Element['roster']) && isset($Element['roster'])):
                            foreach ($Element['roster'] as $player):
                                echo '<tr>';
                                echo '<td>' . $player->DisplayName . '</td>';
                                echo '<td>' . $player->EMail . '</td>';
                                if ($player->isCaptain)
                                    echo '<td>C</td>';
                                else
                                    echo '<td><img id="' . $player->EMail . '" class="delete_icon cp" /></td>';
                                echo '</tr>';
                            endforeach;
                        endif;
                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                        <?php
                                        break;
                                    case 'hidden':
                                        foreach ($Element['values'] as $hidden)
                                            echo '<input type="hidden" id="' . $hidden[0] . '" name="' . $hidden[0] . '" value="' . $hidden[1] . '">';
                                        break;
                                }
                            }
                            // here we can add extra stuff, NOTICE: it's not embedded in the container for that element!!!
                            if (isset($Element['error'])) {
                                $Name = isset($Element['name']) ? $Element['name'] : $Element['id'];
                                echo '<div id="' . $Name . '-error" class="error">';
                                echo '<label for="' . $Name . '" class="error" generated="true"></label>';
                                echo '</div>';
                            }
                            echo '</div>'; // End the overall wrapper
                        }

                        echo '<div class="standard_form_footer clearfix">';
                        echo '<input class="button button_auto light_blue pull_right" type="submit" value="' . SnController::__($Submitbutton) . '">';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '<script type="text/javascript">loadCheckboxes();</script>';
                    }

                    public static function parseYoutubeVideo($url) {
                        $thumb = $url;
                        $thumb = str_replace('&#8211;', '--', $thumb);
                        $thumb = strip_tags($thumb);
                        $link = parse_url($thumb);
                        if (isset($link['host'])) {
                            $link['host'] = str_replace('www.', '', $link['host']);
                            switch ($link['host']) {
                                case "youtu.be":
                                    if (isset($link['path'])) {
                                        $youtubeId = substr($link['path'], 1);
                                    }
                                    break;
                                case "youtube.com":
                                    if (isset($link['query'])) {
                                        parse_str($link['query'], $qs);
                                        $youtubeId = $qs['v'];
                                    }
                                    break;
                            }
                            if (isset($youtubeId)) {
                                $title = self::get_yt_title($youtubeId);
                                $videoInfo = file_get_contents('http://gdata.youtube.com/feeds/api/videos/' . $youtubeId . '?v=2&alt=json');
                                $videoInfo = json_decode($videoInfo);

                                if (!$youtubeId)
                                    return FALSE;

                                $result['type'] = VIDEO_YOUTUBE;
                                $result['title'] = strip_tags($title);
                                $result['content'] = DooTextHelper::limitChar(ContentHelper::handleContentInput($videoInfo->entry->{'media$group'}->{'media$description'}->{'$t'}), VIDEO_DESCRIPTION_LENGTH);
                                $result['id'] = str_replace("\r", '', $youtubeId);

                                return serialize($result);
                            }
                        }
                    }

                    public static function get_yt_title($clip_id) {
                        $h = get_headers('http://gdata.youtube.com/feeds/api/videos/' . $clip_id);
                        if ($h[0] == 'HTTP/1.0 400 Bad Request')
                            return FALSE;

                        $entry = @simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $clip_id);
                        return ($entry) ? ucwords(strtolower($entry->children('http://search.yahoo.com/mrss/')->group->title)) : FALSE;
                    }

                    public static function parseImageshag($url) {
                        $content = file_get_contents($url, null, null, 0, 2500);
                        $matches = array();
                        $regex_pattern = "/<link rel=\"image_src\" href=\"(.*)\">/";
                        preg_match_all($regex_pattern, $content, $matches);

                        if (!empty($matches) && isset($matches[1]) && isset($matches[1][0])) {
                            $result['type'] = IMAGE_IMAGESHAG;
                            $result['title'] = '';
                            $result['content'] = $matches[1][0];
                            $result['id'] = '';
                            return serialize($result);
                        }
                        return FALSE;
                    }

                    public static function manageShareEnter($stringa, $otype, $oid, $olang = false) {
                        //$allowed = array("a" => 1);
//		$stringa = ContentHelper::safe_html($stringa, $allowed);
                        $stringa = ContentHelper::handleContentInput($stringa);

                        $s = array();
                        $type = WALL_HOME;

                        switch ($otype) {
                            case SHARE_NEWS:
                                if ($olang === false)
                                    return '';

                                $s['content'] = $stringa;
                                $s['type'] = $type;
                                $s['otype'] = $otype;
                                $s['oid'] = $oid;
                                $s['olang'] = $olang;
                                $s['description'] = '';

                                break;
                        }

                        $finalResult = array();
                        $finalResult['type'] = $type;
                        $finalResult['content'] = serialize($s);

                        return (object) $finalResult;
                    }

                    /**
                     * Manages wall input and detects type and fixes strings
                     *
                     */
                    public static function managePostEnter($stringa, $parse = true) {
                        $match = array();
                        $allowed = array("b" => 1, "i" => 1);
                        $stringa = ContentHelper::safe_html($stringa, $allowed);

                        $stringa = preg_replace('!<([A-Z]\w*)
		(?:\s* (?:\w+) \s* = \s* (?(?=["\']) (["\'])(?:.*?\2)+ | (?:[^\s>]*) ) )*
		\s* (\s/)? >!ix', '<\1\5>', $stringa);

                        $break = false;
                        $type = '';
                        $description = '';
                        $content = ''; //serialized

                        $m = preg_match_all('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $stringa, $match);


                        if (!empty($match[0]) and $parse == TRUE) {
                            foreach ($match[0] as $url) {
                                $old_url = $url;
                                $url = str_replace(array('http://', 'https://'), '', $url);
                                $url = 'http://' . $url;

                                $urlArr = parse_url($url);
                                $urlArr['host'] = str_replace('www.', '', $urlArr['host']);

                                if (!empty($urlArr) && isset($urlArr['host'])) {
                                    switch ($urlArr['host']) {
                                        case "imageshack.us":
                                            $iresult = self::parseImageshag($url);
                                            if ($iresult) {
                                                $type = WALL_PHOTO;
                                                $content = $iresult;
                                                $description = self::getDescription($stringa, $old_url);
                                                $break = true;
                                            }
                                            break;

                                        case "youtu.be":
                                        case "youtube.com":
                                            $vresult = self::parseYoutubeVideo($url);
                                            if ($vresult) {
                                                $type = WALL_VIDEO;
                                                $content = $vresult;
                                                $c = (object) unserialize($content);
//								$videoInfo = file_get_contents('http://gdata.youtube.com/feeds/api/videos/' . $c->id . '?v=2&alt=json');
                                                $description = self::getDescription($stringa, $old_url);
                                                $break = true;
                                            }
                                            break;

                                        default:
                                            $lresult = self::parseLink($url);
                                            if ($lresult) {
                                                $type = WALL_LINK;
                                                $content = $lresult;
                                                $description = self::getDescription($stringa, $old_url);
                                                $break = true;
                                            }
                                            break;
                                    }
                                }
                                if ($break == true) {
                                    break;
                                }
                            }
                        }

                        if ($type == '') {
                            $type = WALL_HOME;
                            $content = mb_substr($stringa, 0, 1000);
                            $description = '';
                        }

                        $s = array();
                        $s['content'] = $content;
                        $s['type'] = $type;
                        $s['description'] = DooTextHelper::limitChar(self::handleContentInput($description), 1000);

                        $finalResult = array();
                        $finalResult['type'] = $type;
                        $finalResult['content'] = serialize($s);

                        return (object) $finalResult;
                    }

                    public static function getDescription($content, $erase) {
                        return str_replace(array($erase . "\n", $erase . " ", $erase), '', $content);
                    }

                    public static function handleContentOutput($content) {
                        $content = nl2br($content);
                        $content = DooTextHelper::convertUrl($content, '', '_blank');
                        htmlentities($content, ENT_QUOTES, 'utf-8');

                        return $content;
                    }

                    public static function handleContentInput($content) {
                        $allowed = array("br" => 0, "li" => 1, "ol" => 1, "ul" => 1);
                        $content = ContentHelper::safe_html($content, $allowed);

                        //XSS atack prevention
                        $content = preg_replace('!<([A-Z]\w*)
		(?:\s* (?:\w+) \s* = \s* (?(?=["\']) (["\'])(?:.*?\2)+ | (?:[^\s>]*) ) )*
		\s* (\s/)? >!ix', '<\1\5>', $content);

                        return $content;
                    }

                    public static function handleContentInputWysiwyg($content) {
                        $allowed = array(
                            "br" => 0,
                            "li" => 1,
                            "ol" => 1,
                            "ul" => 1,
                            "img" => 1,
                            "blockquote" => 1,
                            "b" => 1,
                            "small" => 1,
                            "i" => 1,
                            "u" => 1,
                            "div" => 1,
                            "font" => 1,
                            "a" => 1
                        );
                        $content = ContentHelper::safe_html($content, $allowed);

                        //XSS atack prevention.
                        $content = preg_replace_callback('!<([A-Z]\w*)(\s* (\w+) \s* = \s* (?(?=["\'])(["\'])(.*?\4)+ | (?:[^\s>]*) ) )*(\s/)? >!ix', 'ContentHelper::decodeWysiwyg', $content);

                        return $content;
                    }

                    private static function decodeWysiwyg($m) {
                        $attr = '';
                        $tag_name = strtolower($m[1]);
                        if ($tag_name == 'a') {
                            $regex = '!\shref\s*=\s*["\'`]?([^\s"\']+[\'`"])!i';
                            if (!preg_match($regex, $m[2], $t)) {
                                return;
                            }
                            $attr = $t[0];
                        }
                        if ($tag_name == 'img') {
                            $regex = '!\ssrc\s*=\s*["\'`]?([^\s"\']+[\'`"])!i';
                            if (!preg_match($regex, $m[2], $t)) {
                                return;
                            }
                            $attr = $t[0];
                        }
                        return "<{$tag_name}{$attr}>";
                    }

                    public static function parseLink($url) {
                        $validhost = filter_var(gethostbyname(parse_url($url, PHP_URL_HOST)), FILTER_VALIDATE_IP);
                        if (!$validhost) {
                            return FALSE;
                        }

                        $result = array();
                        $page = file_get_contents($url);

                        $en = mb_detect_encoding($page, 'UTF-8, ISO-8859-1', true);
                        if (!$en)
                            return FALSE;

                        if ($en != 'UTF-8') {
                            $page = iconv($en, 'UTF-8', $page);
                        }

                        //take paragraphs
                        $result['content'] = '';
                        $result['title'] = '';
                        $result['img'] = '';
                        $result['url'] = $url;

                        preg_match_all("#<p>(.*)</p>#isU", $page, $p);

                        if (isset($p[1]) and !empty($p[1])) {
                            foreach ($p[1] as $pr) {
                                if (mb_strlen($pr) > 100) {
                                    $result['content'] = DooTextHelper::limitChar(self::handleContentInput($pr), 300);
                                    break;
                                }
                            }
                            if ($result['content'] == '') {
                                $result['content'] = DooTextHelper::limitChar(self::handleContentInput($p[1][0]), 300);
                            }
                        }

                        //take images
                        $regex_pattern = '/http:\/\/[^"]+(jpg|jpeg|png)/Ui';
                        preg_match($regex_pattern, $page, $i);
                        if (isset($i[0])) {
                            $result['img'] = $i[0];
                        }

                        preg_match("/<title>(.*)<\/title>+/i", $page, $t);
                        if (isset($t[1])) {
                            $result['title'] = $t[1];
                        }

                        return serialize($result);
                    }

                    public static function articleFeaturedIntro($text) {
                        return DooTextHelper::limitChar(strip_tags($text), 130);
                    }

                    public static function articleFeaturedHeadline($text) {
                        return DooTextHelper::limitChar($text, 60);
                    }

                    public static function downloadShortDescription($text) {
                        return DooTextHelper::limitChar($text, 270);
                    }

                    public static function groupShortDescription($text) {
                        return DooTextHelper::limitChar($text, 230);
                    }

                    public static function gameShortDescription($text) {
                        return DooTextHelper::limitChar($text, 170);
                    }

                    // first, an HTML attribute stripping function used by safe_html()
//   after stripping attributes, this function does a second pass
//   to ensure that the stripping operation didn't create an attack
//   vector.
                    public static function strip_attributes($html, $attrs) {
                        if (!is_array($attrs)) {
                            $array = array("$attrs");
                            unset($attrs);
                            $attrs = $array;
                        }

                        foreach ($attrs AS $attribute) {
                            // once for ", once for ', s makes the dot match linebreaks, too.
                            $search[] = "/" . $attribute . '\s*=\s*".+"/Uis';
                            $search[] = "/" . $attribute . "\s*=\s*'.+'/Uis";
                            // and once more for unquoted attributes
                            $search[] = "/" . $attribute . "\s*=\s*\S+/i";
                        }
                        $html = preg_replace($search, "", $html);

                        // do another pass and strip_tags() if matches are still found
                        foreach ($search AS $pattern) {
                            if (preg_match($pattern, $html)) {
                                $html = strip_tags($html);
                                break;
                            }
                        }
                        return $html;
                    }

                    public static function js_and_entity_check($html) {
                        // anything with ="javascript: is right out -- strip all tags if found
                        $pattern = "/=[\S\s]*s\s*c\s*r\s*i\s*p\s*t\s*:\s*\S+/Ui";
                        if (preg_match($pattern, $html)) {
                            return TRUE;
                        }

                        // anything with encoded entites inside of tags is out, too
                        $pattern = "/<[\S\s]*&#[x0-9]*[\S\s]*>/Ui";
                        if (preg_match($pattern, $html)) {
                            return TRUE;
                        }

                        return FALSE;
                    }

                    //note, there is a special format for $allowedtags, see ~line 90
                    public static function safe_html($html, $allowedtags = "") {

                        // check for obvious oh-noes
                        if (ContentHelper::js_and_entity_check($html)) {
                            $html = strip_tags($html);
                            return $html;
                        }

                        // setup -- $allowedtags is an array of $tag=>$closeit pairs,
                        //   where $tag is an HTML tag to allow and $closeit is 1 if the tag
                        //   requires a matching, closing tag
                        if ($allowedtags == "") {
                            $allowedtags = array("p" => 1, "br" => 0, "a" => 1, "img" => 0,
                                "li" => 1, "ol" => 1, "ul" => 1,
                                "b" => 1, "i" => 1, "em" => 1, "strong" => 1,
                                "del" => 1, "ins" => 1, "u" => 1, "code" => 1, "pre" => 1,
                                "blockquote" => 1, "hr" => 0
                            );
                        } elseif (!is_array($allowedtags)) {
                            $array = array("$allowedtags");
                        }

                        // there's some debate about this.. is strip_tags() better than rolling your own regex?
                        // note: a bug in PHP 4.3.1 caused improper handling of ! in tag attributes when using strip_tags()
                        $stripallowed = "";
                        foreach ($allowedtags AS $tag => $closeit) {
                            $stripallowed.= "<$tag>";
                        }

                        //print "Stripallowed: $stripallowed -- ".print_r($allowedtags,1);
                        $html = strip_tags($html, $stripallowed);



                        // also, lets get rid of some pesky attributes that may be set on the remaining tags...
                        // this should be changed to keep_attributes($htmlm $goodattrs), or perhaps even better keep_attributes
                        //  should be run first. then strip_attributes, if it finds any of those, should cause safe_html to strip all tags.
                        $badattrs = array("on\w+", "style", "fs\w+", "seek\w+");
                        $html = ContentHelper::strip_attributes($html, $badattrs);

                        // close html tags if necessary -- note that this WON'T be graceful formatting-wise, it just has to fix any maliciousness
                        foreach ($allowedtags AS $tag => $closeit) {
                            if (!$closeit)
                                continue;
                            $patternopen = "/<$tag\b[^>]*>/Ui";
                            $patternclose = "/<\/$tag\b[^>]*>/Ui";
                            $totalopen = preg_match_all($patternopen, $html, $matches);
                            $totalclose = preg_match_all($patternclose, $html, $matches2);
                            if ($totalopen > $totalclose) {
                                $html.= str_repeat("</$tag>", ($totalopen - $totalclose));
                            }
                        }

                        // check (again!) for obvious oh-noes that might have been caused by tag stipping
                        if (ContentHelper::js_and_entity_check($html)) {
                            $html = strip_tags($html);
                            return $html;
                        }

                        // close any open <!--'s and identify version just in case
//		$html.= '<!-- ' . SAFE_HTML_VERSION . ' -->';

                        return $html;
                    }

                }
                ?>
