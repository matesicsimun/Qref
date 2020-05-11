<?php

declare(strict_types = 1);

function create_doctype(){
    printf("<!DOCTYPE html>");
}

function begin_html(){
    printf("<html>");
}

function end_html(){
    printf("</html>");
}

function begin_head(){
    printf("<head>");
}

function end_head(){
    printf("</head>");
}

function begin_body(array $params){
    printf(create_element('body', true, $params));
}

function end_body(){
    printf("</body>");
}

function create_table($params){
    printf(create_element("table", false, $params));
}

function end_table(){
    printf("</table>");
}

function create_table_row($params): string{
    return create_element('tr', true, $params);
}

function create_table_cell($params): string{
    return create_element('td', true, $params);
}

function create_element($name, $closed = true, $params): string{
    $html = "<$name ";

    foreach ($params as $attribute => $value){
        if ($attribute !== 'contents'){
            $html .= "$attribute=\"$value\" ";
        }
    }
    $html .= ">";

    if (array_key_exists('contents', $params)){
        if (is_array($params['contents'])){
            foreach ($params['contents'] as $cellValue){
                $html .= $cellValue;
            }
        }
        else if($params['contents'] != ''){
            $html .= $params['contents'];
        }
    }

    if ($closed){
        $html .= "</" . $name . ">";
    }

    return $html;
}

/**
 * Following section contains newly added functions - DZ 2
 */

/**
 * @param {string} $action relativna ili apsolutna putanja
 * do skripte za obradu obrasca
 * @param {string} $method GET ili POST
 */
function start_form($action, $method, $enctype=NULL){
    if (strtoupper($method) === 'GET' || strtoupper($method) === 'POST'){
        echo create_element("form", false, ["action"=>$action, "method"=>$method, "enctype"=>$enctype]);
    }
}

function end_form(){
    echo "</form>";
}

/**
 * @param {array} $params asocijativno polje parova oblika
 * atribut => vrijednost
 * @return niz znakova koji predstavlja generirani input tag
 */
function create_input($params): string{
    return create_element("input", false, $params);
}

/**
 * @param {array} $params polje parametara koje odredjuje
 * padajuci izbornik
 * @return niz znakova koji predstavlja generirani select tag
 */
function create_select($params):string{
    return create_element("select", true, $params);
}

/**
 * @param {array} $params
 * @return string
 */
function create_button($params): string {
    return create_element("button",true, $params);
}

/**
 * Creates an array of HTML input elements.
 * @param array $types
 * @param array $names
 * @param array $ids
 * @param array $attributes
 * @return array
 */
 function createInputs(array $types, array $names, array $ids, array $attributes){
    $inputs = [];

    for ($i = 0; $i < sizeof($types); $i++){
        $input = new HTMLInputElement();
        $input->add_attribute(new HTMLAttribute("type", $types[$i]));
        $input->add_attribute(new HTMLAttribute("name", $names[$i]));
        $input->add_attribute(new HTMLAttribute("id", $ids[$i]));

        if(isset($attributes[$names[$i]])){
            $curAttributes = $attributes[$names[$i]];
            foreach($curAttributes as $attrName => $attrVal){
                $input->add_attribute(new HTMLAttribute($attrName, $attrVal));
            }
        }

        $inputs[] = $input;
    }

    return $inputs;
}

/**
 * Creates an array of HTML label elements.
 * @param array $text
 * @param array $for
 * @return array
 */
 function createLabels(array $text, array $for): array{
    $labels = [];

    for ($i = 0; $i < sizeof($text); $i++){
        $label = new HTMLLabelElement();
        $label->add_child(new HTMLTextNode($text[$i]));
        $label->add_attribute(new HTMLAttribute("for", $for[$i]));

        $labels[] = $label;
    }

    return $labels;
}