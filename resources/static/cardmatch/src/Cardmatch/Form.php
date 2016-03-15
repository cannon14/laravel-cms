<?php

/**
 * Main form for Cardmatch
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */
class Cardmatch_Form extends Zend_Form {


	public function init() {


		$translateValidators = array(
			Zend_Validate_NotEmpty::IS_EMPTY => 'cannot be blank.',
			Zend_Validate_StringLength::TOO_SHORT => 'cannot be shorter than %min% characters.',
			Zend_Validate_StringLength::TOO_LONG => 'cannot be longer than %max% characters.',
			Zend_Validate_Alpha::NOT_ALPHA => "must contain letters only.",
			Zend_Validate_Digits::NOT_DIGITS => "must contain numbers only.",
            Zend_Validate_Regex::NOT_MATCH => "must contain letters, numbers, hyphens, apostrophes, periods and roman numerals only."
		);

		$translator = new Zend_Translate('array', $translateValidators);
		Zend_Validate_Abstract::setDefaultTranslator($translator);

		$alphaWithSpaces = new Zend_Validate_Alpha(true);

        // Names allow hyphens, periods, and apostrophes
        $nameRegEx = new Zend_Validate_Regex('/(^[a-zA-Z\.\'\-0-9 ]+$)/');
		$addressRegEx = new Zend_Validate_Regex('/(^[a-zA-Z\.\'\-0-9 #]+$)/');
		$cityRegEx =  new Zend_Validate_Regex('/^[a-z A-Z.\'-]+$/');

		$firstName = new Zend_Form_Element_Text('firstName');
		$firstName->setLabel('First Name')
				  ->setRequired()
				  ->addValidator($nameRegEx);

		$middle = new Zend_Form_Element_Text('middleInitial');
		$middle->setLabel('Middle Initial')
				->addValidator($alphaWithSpaces)
				->addValidator('stringLength', false, array(0,1));

		$lastName = new Zend_Form_Element_Text('lastName');
		$lastName->setLabel('Last Name')
				 ->setRequired()
                 ->addValidator($nameRegEx);

		$street = new Zend_Form_Element_Text('streetAddress');
		$street->setLabel('Street address')
				->setRequired()
				->addValidator($addressRegEx);

		$city = new Zend_Form_Element_Text('city');
		$city->setLabel('City')
				->setRequired()
			    ->addValidator($cityRegEx);

		$state = new Zend_Form_Element_Text('state');
		$state->setLabel('State')
			  ->setRequired()
			  ->addValidator($alphaWithSpaces);

		$zip = new Zend_Form_Element_Text('zipCode');
		$zip->setLabel('Zip Code')
			->setRequired()
		    ->addValidator('Digits');

		$ssn = new Zend_Form_Element_Text('ssn');
		$ssn->addValidator('Digits')
			->addValidator('stringLength', false, array(4,4))
			->setRequired()
			->setLabel('Social security number');

		$this->addElements(array(
			$firstName, $middle, $lastName, $street, $city, $state, $zip, $ssn
		));


	}

	public function populateFromUser(Cardmatch_User $user) {

		$data = array(
			'firstName' => $user->getFirstName(),
			'middleInitial' => $user->getMiddleInitial(),
			'lastName' => $user->getLastName(),
			'streetAddress' => $user->getStreetAddress(),
			'city' => $user->getCity(),
			'state' => $user->getState(),
			'zipCode' => $user->getZipCode(),
		);

		$this->populate($data);

	}


}
