<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SampleClass
 *
 * @author femi
 */
class PersonSampleClass extends isess\ADb {
    // define all your database columns as class variables
    // ensure they have the exact same name
    private $firstname;
    private $surname;
    private $dob;
    private $isMale;
    private $nationality;
    private $children;
    
    // Ensure you call the parent constructor
    public function __construct($_id, $_fieldlist, $_createOnDb = false) {
        // define the fields to types using the format 'class variable' => 'database type'
        $fieldToTypes = array('firstname' => '%s',
                              'surname' => '%s',
                              'dob' => '%s',
                              'isMale' => '%b',
                              'nationality' => '%s',
                              'children' => '%d');
        parent::__construct($_id, $_fieldlist, $fieldToTypes, $_createOnDb);
    }
    
    // YOU CAN OVERRIDE THE DEFAULT DATABASE ACCESS FUNCTIONS IF NECESSARY
    
    // DEFINE GETTERS AND SETTERS
    function getFirstname() {
        return $this->firstname;
    }
    function getSurname() {
        return $this->surname;
    }
    function getDob() {
        return $this->dob;
    }
    function getIsMale() {
        return $this->isMale;
    }
    function getNationality() {
        return $this->nationality;
    }
    function getChildren() {
        return $this->children;
    }
    
    
    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
    function setSurname($surname) {
        $this->surname = $surname;
    }
    function setDob($dob) {
        $this->dob = $dob;
    }
    function setIsMale($isMale) {
        $this->isMale = $isMale;
    }
    function setNationality($nationality) {
        $this->nationality = $nationality;
    }
    function setChildren($children) {
        $this->children = $children;
    }
}


// CREATE A NEW PERSON AND SAVE TO THE DATABASE
$dob = Utilities::formatDateTime("14-12-1970",  Utilities::DATEFORM_CALENDAR_DATE);
$theUser = new PersonSampleClass(NULL, array('firstname' => 'james',
                                            'surname' => 'bond',
                                            'dob' => $dob,
                                            'isMale' => true,
                                            'nationality' => 'British',
                                            'children' => 2), true);

// CREATE A NEW PERSON AND SAVE TO THE DATABASE 2
$theUser = new PersonSampleClass(NULL, NULL);
$theUser->setChildren(2);
$theUser->setDob($dob);
$theUser->setFirstname('bond');
$theUser->setIsMale(true);
$theUser->setNationality('British');
$theUser->setSurname('bond');
$theUser->create();

// INITIALISE A PERSON CLASS FROM ITS ID
$id=34;
$theUser = new PersonSampleClass($id);


// RETREIVE A CLASS MEMBER
$firstname = $theUser->getFirstname();

// PULL THE LATEST UPDATE FROM THE DB
$fieldlist = $theUser->get();       

// PULL THE LATEST UPDATE FROM THE DB for a limited set of fields
$customFieldlist = $theUser->get(array('firstname','dob','children'));       

// RETRIEVE A PERSON CLASS THAT MATCHES A CERTAIN CONDITION 1 
$theUser->get(NULL, 0, "surname='bond'");

// RETRIEVE A PERSON CLASS THAT MATCHES A CERTAIN CONDITION 2
$theUser = new PersonSampleClass(NULL, $_fieldlist, true);

// RETRIEVE A SET OF PERSON CLASS THAT MATCHES A CERTAIN CONDITION 
$people = PersonSampleClass::_get(array('firstname','surname','dob','isMale',
                                        'nationality' => 'British','children', 'isMale=1'));

// UPDATE A PERSON CLASS 1
$theUser->update(array('firstname' => 'secret agent','children' => 0));

// UPDATE A PERSON CLASS 2
$theUser->setChildren(0);
$theUser->setFirstname('secret agent');
$theUser->update();

// UPDATE A PERSON CLASS UNDER A CERTAIN CONDITION
$theUser->update(array('firstname' => 'secret agent','children' => 0),
                 "surname='bond'");

// UPDATE ONE OR MORE PERSON CLASSES THAT MATCH UNDER A CERTAIN CONDITION
PersonSampleClass::_update(array('firstname' => 'secret','surname' => 'agent'), 'children=0');

// DELETE A PERSON CLASS
$theUser->delete();
// DELETE A SET OF PERSON CLASS THAT MATCH A CONDITION
PersonSampleClass::_delete('children=0');