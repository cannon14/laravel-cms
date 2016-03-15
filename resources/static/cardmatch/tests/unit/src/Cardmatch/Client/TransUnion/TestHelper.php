<?php

/**
 * TransUnion Test Helper
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class TransUnion_TestHelper {



	/**
	 * @param Cardmatch_Client_TransUnion_Request $request
	 * @param Cardmatch_User $user
	 * @param boolean $ncbh whether or not to return a NCBH error code
	 *
	 * @return string
	 */
	public function getTestResponseString(Cardmatch_Client_TransUnion_Request $request, Cardmatch_User $user, $ncbh = false) {

		$serviceCode = '01';

		// ** Build Test Response String **
		$responseString = $request->format(62,"TU4R062111" . $request->getRequestId() . "XXXXXX" . "12345678" . "20090918" . "033030");
		$responseString .= $request->format(12,"PH01" . "012" . $serviceCode);
		$responseString .= $request->format(33, "DI01" . "033" . "L1" . substr($request->getExternalVisitId(), 0, 24) );
		$responseString .= $request->format(33, "DI01" . "033" . "L1" . substr($request->getExternalVisitId(), 24, 32) );

		if($ncbh) {
			$responseString .= $this->_getNoCreditBureauHit($request);
		} else {
			$responseString .= $this->_getBuckets($request);
		}


		$responseString .= $request->format(109, "CS01" . "109" . "01" . "blah" );
		$responseString .= $request->format(17, "AO01" . "017" . "07000" . "01" . "XXX"); // 1 per model
		$responseString .= $request->format(34, "SC01" . "034" . "12345" . "+" . "XXXXX" . "1" . "B" . "123" . "123" . "123" . "123" . "12"); // 1 per model
		$responseString .= $request->format(41, "CD01" . "041" . "05" . "1234567");
		$responseString .= $request->format(12, "PH01" . "012" . "07000"); // 07000 = service code for returned credit report

		$responseString .= $request->format(27, "SH01" . "027" . "1" . "12" . "Y" . "03" . "N" . "12" . "12" . "N" . "20010101" ); // subject header for subject #1
		$responseString .= $request->format(70, "NM01" . "070" . "I" . "1" .
				$request->format(25,$user->getLastName()) .
				$request->format(15,$user->getFirstName()) .
				$request->format(15,$user->getMiddleInitial()) );
		$responseString .= $request->format(29, "PI01" . "029" . "I" . $user->getSSN() . "19801213" . "28" . "M" );

		/*
		$responseString .= $request->format(105, "AD01" . "105" . "I" . "1" . "0" .
				$request->format(10,$user->getHouseNumber()) .
				$request->format(2,$user->getPredirectional()) .
				$request->format(27,$user->getStreetName()) .
				$request->format(2) .
				$request->format(2,$user->getStreetType()) .
				$request->format(5,$user->getAptNumber()) .
				$request->format(27, $user->getCity()) .
				$request->format(2, $user->getState()) .
				$request->format(10, $user->getZipCode()) );*/


		$streetAddress = $user->getStreetAddress();
		$address = preg_split("[ ]", $streetAddress, 2);
		$segments[] = $request->format(97, "AD01" . " " .
				$request->format(10, $address[0]) .
				$request->format(2, '') .
				$request->format(27, $address[1]) .
				$request->format(2) .
				$request->format(2, '') .
				$request->format(5, '') .
				$request->format(27, $user->getCity()) .
				$request->format(2, $user->getState()) .
				$request->format(10, $user->getZipCode()) .
				$request->format(1, "3")); // 1=own, 2=rent, 3=other


		$responseString .= $request->format(100, "EM01" . "100"); // employer info
		$responseString .= $request->format(105, "AD01" . "105"); // employer address
		$responseString .= $request->format(168, "PR01" . "168"); // public record info
		$responseString .= $request->format(160, "CL01" . "160"); // collection record
		$responseString .= $request->format(288, "TR01" . "288"); // trade accounts
		$responseString .= $request->format(77, "MI01" . "077");  // miscellanous statement
		$responseString .= $request->format(109, "CS01" . "109"); // consumer statement
		$responseString .= $request->format(65, "IN01" . "065");  // inquiry statement
		$responseString .= $request->format(148, "OB01" . "148"); // owning bureau identification
		$responseString .= $request->format(17, "AO01" . "017");  // addon status
		$responseString .= $request->format(34, "SC01" . "034");  // scoring segment
		$responseString .= $request->format(10, "ENDS" . "010" . "026");

		return $responseString;
	}


	protected function _getBuckets($request) {

		// a dr01 segment = a bucket
		$responseString = $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"A" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" . // alphabetic code for final decision level
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "AX01") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		// a dr01 segment = a bucket
		$responseString .= $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"A" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" . // alphabetic code for final decision level
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "AX02") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		// a dr01 segment = a bucket
		$responseString .= $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"A" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" . // alphabetic code for final decision level
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "AX24") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		// a dr01 segment = a bucket
		$responseString .= $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"A" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" . // alphabetic code for final decision level
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "CO01") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		// a dr01 segment = a bucket
		$responseString .= $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"A" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" . // alphabetic code for final decision level
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "CO02") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		return $responseString;

	}

	protected function _getNoCreditBureauHit($request) {

		// a dr01 segment = a bucket
		$responseString = $request->format(193, "DR01" . "193" .
				"123456789012" . // * applicant reference ID
				"X" .  // A = approval, D = decline, R = review, X = none/complete
				$request->format(10, "Pass") .  // decision text, "Pass"|"Complete"|"Review"|"None"
				"12" . // final decision level number
				"A" .
				"20090918033030" .  // datetime the decision was returned CCYYMMDDHHMMSS
				"12" . // maximum level attainable
				$request->format(44) . // fail reason from each credit level processed
				$request->format(44) . // * fail reasons in compressed format (no duplicates)
				"123456789" . // the credit line that the Descision Systems service assigned to approval records
				"2" . // bureau ID, 1 = equifax, 2 = transunion, 3 = experian
				"123" . // * error code - in event of invalid FFI input
				"N" . // address mismatch alert, C = current address, P = previos, B = both, N = no mismatch
				"N" . // fraud alert, Y = yes fraud alert, N = no fraud alert
				"N" . // credit data status, Y = credit data suppressed, N = data not suppressed, F = frozen, etc
				$request->format(24,"1234567890") . // * account number - long credit card product name
				$request->format(6, "CO02") . // * bucket id - category id from context 2 in cardbank or cms
				$request->format(10)  // special customer requests
		);

		return $responseString;
	}


	public function getConfig($env = 'unittesting') {
		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', $env);
		$channelConfig = $config->channels->TransUnion->params;
		return $channelConfig;
	}

	/**
	 * @param int $userId
	 *
	 * @return Cardmatch_User
	 */
	public function getTestUser($userId = 0) {
		$testUsers = new Cardmatch_Client_TransUnion_TestUsers();
		$users = $testUsers->getTestUsers();
		return $users[$userId];
	}

	public function getVisitId() {
		$visitId = '123456789';
		return $visitId;
	}

}
