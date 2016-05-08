<?php
if (!class_exists('AtfHtmlHelper')) {
    class AtfHtmlHelper
    {
        public static function assets ($url = null) {
            if (!$url) { $url = plugin_dir_url(__FILE__); }
            wp_enqueue_style('atf-options-css', $url . 'assets/options.css', array(), '1.0', 'all');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script('atf-options-js', $url . 'assets/atf-options.js', array('jquery', 'wp-color-picker', 'jquery-ui-sortable'), '1.0', false);
            wp_enqueue_media();
            wp_localize_script('atf-options-js', 'atf_html_helper', array('url' => $url . 'assets/blank.png'));
        }

        /**
         * @param array $args
         */
        public static function group($args = array())
        {

            ?>


            <table class="form-table atf-options-group">
                <thead>
                <tr>
                    <th class="group-row-id">#</th>
                    <?php

                    foreach ($args['items'] as $key => $item) {
                        echo '<th>' . esc_html($item['title']) . '</th>';
                    }
                    
                    ?>
                    <th class="group-row-controls"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;

                foreach ($args['value'] as $row_key => $row_val) {
                    echo '<tr class="row">';
                    echo '<td class="group-row-id">' . $i . '</td>';
                    foreach ($args['items'] as $key => $item) {
                        $item['id'] = $key;
                        $item['desc'] = null;
                        $item['uniqid'] = uniqid($item['id']);
                        $item['name'] = $args['name'] . '[' . $row_key . '][' . $item['id'] . ']';


                        if (!isset($row_val[$item['id']])) {
                            $item['value'] = '';
                        } else {
                            $item['value'] = $row_val[$item['id']];
                        }
                        if (!isset($item['cell_style'])) $item['cell_style'] = '';



                        echo '<td '
                            .'style="' . $item['cell_style'] . '"'
                            .'data-field-type="' . esc_attr($item['type']) . '" '
                            .'data-field-name-template="' . esc_attr($args['name'] . '[#][' . $item['id'] . ']') . '">';
                        $item['id'] = $item['uniqid'];
                        echo self::$item['type']($item);
                        echo '</td>';


                    }
                    echo '<td class="group-row-controls">';
                    echo '<a class="btn-control-group plus" href="#" >+</a>';
                    echo '<a class="btn-control-group minus" href="#" >&times;</a>';
                    echo '</td>';
                    echo '</tr>';
                    $i++;
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td class="group-row-id">#</td>
                    <?php

                    foreach ($args['items'] as $key => $item) {

                        echo '<td>';
                        echo (empty($item['desc'])) ? '' : '<p  class="description">' . esc_html($item['desc']) . '</p>';
                        echo '</td>';
                    }

                    ?>
                    <th class="group-row-controls"></th>
                </tr>
                </tfoot>
            </table>


        <?php
        }

        /**
         * @param array $args
         */
        public static function text($args = array())
        {
            $args = wp_parse_args($args, array(
                'value' => '',
                'class' => 'regular-text',
                'addClass' => '',
            ));

            $result = '<input type="text" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" value="' . esc_attr($args['value']) . '" class="' . esc_attr($args['class'] . $args['addClass']) . '" />';
            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;
        }        /**
         * @param array $args
         */
        public static function number($args = array())
        {
            $args = wp_parse_args($args, array(
                'value' => '',
                'class' => 'regular-text',
                'addClass' => '',
                'step' => 1,
                'min' => 0,
            ));

            $result = '<input type="number" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" value="' . esc_attr($args['value']) . '" class="' . esc_attr($args['class'] . $args['addClass']) . '" />';
            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;
        }

        /**
         * @deprecated
         * @param array $args
         */
        public static function textField($args = array())
        {
            self::text($args);
        }

        /**
         * @param array $args
         */
        public static function media($args = array()) {
            $default = array(
                'value' => '',
                'class' => 'regular-text',
                'addClass' => '',
            );

            $args = wp_parse_args($args, $default);

            $result = '<div class="uploader">';
            $result .= '<input type="hidden" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" value="' . esc_url($args['value']) . '" class="' . esc_attr($args['class'] . $args['addClass']) . '" />';
            $result .= '<img class="atf-options-upload-screenshot" id="' . esc_attr('screenshot-' . $args['id']) . '" src="' . esc_url($args['value']) . '" />';
            if ($args['value'] == '') {
                $remove = ' style="display:none;"';
                $upload = '';
            } else {
                $remove = '';
                $upload = ' style="display:none;"';
            }
            $result .= ' <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="atf-options-upload button-secondary"' . $upload . ' rel-id="' . esc_attr($args['id']) . '">' . __('Upload', 'atf') . '</a>';
            $result .= ' <a href="javascript:void(0);" class="atf-options-upload-remove  button-secondary"' . esc_attr($remove) . ' rel-id="' . esc_attr($args['id']) . '">' . __('Remove Upload', 'atf') . '</a>';
            $result .= '</div>';


            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;

        }

        /**
         * @deprecated
         * @param array $args
         */
        public static function addMedia($args = array())
        {
            self::media($args);
        }

        /**
         * @param array $args
         */
        public static function color($args = array()){
            $args = wp_parse_args($args, array(
                'value' => '',
                'class' => 'color-picker-hex',
                'addClass' => '',
            ));

            $result = '<div class="customize-control-content"><input type="text" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" value="' . $args['value'] . '" class="' . $args['class'] . $args['addClass'] . '" /></div>';
            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;

        }

        /**
         * @deprecated
         * @param array $args
         */
        public static function colorPicker($args = array())
        {
            self::color($args);
        }

        public static function textarea($args = array())
        {
            $default = array(
                'value' => '',
                'class' => 'regular-text',
                'addClass' => '',
                'rows' => 10,
                'cols' => 50,
            );
            foreach ($default as $key => $value) {
                if (!isset($args[$key])) {
                    $args[$key] = $value;
                }
            }
            $result = '<textarea id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" rows="' . esc_attr($args['rows']) . '" cols="' . esc_attr($args['cols']) . '" class="' . esc_attr($args['class'] . $args['addClass']) . '" >' . esc_textarea($args['value']) . '</textarea>';
            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }
            echo $result;
        }




        public static function editor($args = array()) {
            $default = array(
                'value' => '',
                'class' => 'regular-text',
                'addClass' => '',
                'rows' => 10,
                'cols' => 50,
                'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => false, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                    'tabindex' => '',
                    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
                    'editor_class' => '', // add extra class(es) to the editor textarea
                    'teeny' => false, // output the minimal editor config used in Press This
                    'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
                    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                    'quicktags' => true, // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ',
                    'toolbar3' => '',
                    'toolbar4' => '',
                ),
            );
            foreach ($default as $key => $value) {
                if (!isset($args[$key])) {
                    $args[$key] = $value;
                }
            }
            $args['options']['textarea_name'] = $args['name'];
            wp_editor(stripslashes($args['value']), $args['id'], $args['options']);
            if (isset($args['desc'])) {
                echo '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

        }

        /**
         * @deprecated
         * @param array $args
         */
        public static function wysiwyg($args = array())
        {
            self::editor($args);
        }

        public static function tumbler($args = array())
        {
            self::onOffBox($args);
        }

        public static function onOffBox($args = array())
        {

            $on = '';
            if (!empty($args['value'])) {
                $on = 'on';
            }
            if (empty($args['name'])) {
                $args['name'] = $args['id'];
            }
            $result = '<a class="' . esc_attr('on-off-box ' . $on) . '" href="#">';
            $result .= '<span class="tumbler"></span>';
            $result .= '<span class="text on">on</span>';
            $result .= '<span class="text off">off</span>';
            $result .= '<input type="radio" class="on" name="' . esc_attr($args['name']) . '" value="1"  ' . checked($args['value'], '1', false) . ' >';
            $result .= '<input type="radio" class="off" name="' . esc_attr($args['name']) . '" value="0" ' . checked($args['value'], '0', false) . ' >';
            $result .= '<span class="text off">off</span>';
            $result .= '</a>';

            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;
        }

        public static function select($args)
        {
            if (isset($args['taxonomy'])) {

                self::selectFromTaxonomy($args);
            } else {
                $result = '<select name="' . esc_attr($args['name']) . '">';

                if (!isset($args['values'])) {
                    $args['values'] = $args['options'];
                }

                foreach ($args['values'] as $value => $text) {
                    $result .= '<option value="' . esc_attr($value) . '" ' . selected($value, $args['value'], false) . ' > ' . $text . ' </option>';
                }

                $result .= '</select>';

                echo $result;
            }

        }

        public static function taxonomy_select($args)
        {
            self::selectFromTaxonomy($args);
        }

        public static function selectFromTaxonomy($args)
        {
            if (taxonomy_exists($args['taxonomy'])) {
                $args['selected'] = $args['value'];
                wp_dropdown_categories($args);
            } else {
                var_dump(get_taxonomies());
                echo "Taxonomy not exist";
            }
            if (isset($args['desc'])) {
                echo '<p class="description">' . esc_html($args['desc']) . '</p>';
            }
        }
    //    public static function


        public static function checkboxTaxonomy($args)
        {

            if (taxonomy_exists($args['taxonomy'])) {
                if (!is_array($args['value'])) {
                    $args['value'] = array($args['value']);
                }

                $cats = get_terms(array(
                        'taxonomy' => $args['taxonomy'],
                        'hide_empty' => $args['hide_empty'],
                    ));

                $result = '';


                foreach ($cats as $cat) {
                    $result .= ' <label><input type="checkbox"'
                        . ' name="' . esc_attr($args['name'] . '[]') . '"'
                        . ' value="' . esc_attr($cat->term_id) . '" ';
                    $result .= (in_array($cat->term_id, $args['value'])) ? 'checked="checked"' : '';
                    $result .= ' > ' . esc_html($cat->name) . '</label> ';

                }

                $result .= '';

                if (isset($args['desc'])) {
                    $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
                }

                echo $result;
            } else {
                var_dump(get_taxonomies());
                echo "Taxonomy not exist";
            }

        }

        /**
         * @deprecated
         * @param array $args
         *
         */
        public static function radioButtons($args = array())
        {

            $default = array(
                'value' => '',
                'class' => '',
                'addClass' => '',
            );

            foreach ($default as $key => $value) {
                if (!isset($args[$key])) {
                    $args[$key] = $value;
                }
            }

            $result = '';
            $result .= '<fieldset class="' . esc_attr($args['class'] . $args['addClass']) . '" >';
            foreach ($args['options'] as $value => $label) {
                $checked = '';
                if ($value == $args['value']) {
                    $checked = "checked";
                }


                $result .= '<label class="' . $checked . '" >';
                $result .= '<input type="radio" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['name']) . '" value="' . esc_attr($value) . '" ' . checked($args['value'], $value, false) . ' />';
                $result .= $label;
                $result .= '</label>';
            }
            $result .= '</fieldset>';

            echo $result;
        }
        public static function radio($args = array())
        {

            $default = array(
                'vertical' => true,
                'value' => '',
                'class' => '',
                'addClass' => '',
            );

            foreach ($default as $key => $value) {
                if (!isset($args[$key])) {
                    $args[$key] = $value;
                }
            }

            $result = '';
            $result .= '<fieldset class="' . esc_attr($args['class'] . $args['addClass']) . '" >';
            foreach ($args['options'] as $value => $label) {
                $id = esc_attr($args['name'] . '__' . $value);
                $checked = '';
                if ($value == $args['value']) {
                    $checked = "checked";
                }

                $result .= '<input type="radio"'
                    . ' id="' . $id . '"'
                    . ' name="' . esc_attr($args['name']) . '" value="' . esc_attr($value) . '" ' . checked($args['value'], $value, false) . ' />';
                $result .= ' <label for="' . $id . '">' . esc_html($label) . '</label> ';
                if ($args['vertical']) $result .= '<br />';
            }
            $result .= '</fieldset>';

            echo $result;
        }

        public static function checkbox($args)
        {
            $args = wp_parse_args($args, array(
                'vertical' => true,
                'value' => '',
                'class' => '',
                'addClass' => '',
            ));

            if (isset($args['taxonomy'])) {
                if (taxonomy_exists($args['taxonomy'])) {
                    $options = self::get_taxonomy_options($args);

                } else {
                    var_dump(get_taxonomies());
                    echo "Taxonomy not exist";
                }
            }

            if (isset($args['options']) && !isset($options)) {
                $options = $args['options'];
            } elseif (isset($args['options']) && isset($options)) {
                $options = $args['options'] + $options;
            } elseif (!isset($args['options']) && !isset($options)) {
                echo 'No options';
                return;
            }


            if (!is_array($args['value'])) {
                $args['value'] = array($args['value']);
            }

            $result = '';
            $result .= '<fieldset class="' . esc_attr($args['class'] . $args['addClass']) . '" >';
            foreach ($options as $val=>$label) {
                $id = esc_attr($args['name'] . '__' . $val);
                $result .= '<input type="checkbox"'
                    . ' id="' . $id . '"'
                    . ' name="' . esc_attr($args['name'] . '[]') . '"'
                    . ' value="' . esc_attr($val) . '" ';
                $result .= (in_array($val, $args['value'])) ? 'checked="checked"' : '';
                $result .= ' > ';
                $result .= ' <label for="' . $id . '">' . esc_html($label) . '</label> ';
                if ($args['vertical']) $result .= '<br />';

            }
            $result .= '</fieldset>';

            if (isset($args['desc'])) {
                $result .= '<p class="description">' . esc_html($args['desc']) . '</p>';
            }

            echo $result;


        }

        public static function get_taxonomy_options($args = array())
        {
            $args = wp_parse_args($args, array(
                'taxonomy' => 'category',
                'hide_empty' => false,
            ));


            $terms = (array)get_terms(array(
                'taxonomy' => $args['taxonomy'],
                'hide_empty' => $args['hide_empty'],
            ));
            // Initate an empty array
            $term_options = array();
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $term_options[$term->term_id] = $term->name;
                }
            }

            return $term_options;
        }

        public static function info($args = array())
        {
            echo 'info';
        }
    }

}