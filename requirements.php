Requirements analysis

ef_forms 
id      form_title              form_description
1        Student Feedback           Dummy


id form_id field_id field_label  field_type 
1     10       1          hhh   scale
1     10       1          hhh   scale
1     10       1          hhh   scale
1     10       1          hhh   scale


$question = array(
    array(
        'label' => 'what is your name',
        'type' => 'scale' 
    ),
    array(
        'label' => 'what is your name',
        'type' => 'vote' 
    ),
    array(
        'label' => 'what is your name',
        'type' => 'scale' 
    ),
    array(
        'label' => 'what is your name',
        'type' => 'vote' 
    ),
);

evaluations

id form_id user_id field_id   feedback
1    10        20       1          yes
1    10        20       1          yes
1    10        20       1          yes
1    10        20       1          yes

submit = array(
    array(
        '1' => 'v'
    ),
    array(
        '2' => 'v'
    ),
    array(
        '3' => 'v'
    ),
    array(
        '4' => 'v'
    ),
)