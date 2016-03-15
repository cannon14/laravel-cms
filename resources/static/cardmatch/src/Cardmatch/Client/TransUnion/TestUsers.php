<?php

/*
 * Used to build and bounce test users against TransUnion test environment
 */
class Cardmatch_Client_TransUnion_TestUsers {

	protected function _createTestUsers() {

		$user1 = new Cardmatch_User();
		$user1->setFirstName('MARY');
		$user1->setMiddleInitial('');
		$user1->setLastName('SMITH');
		$user1->setStreetAddress('0 COMMERCIAL');
		$user1->setCity('FANTASY ISLAND');
		$user1->setState('IL');
		$user1->setZipCode('60750');
		$user1->setSSN('666523655');

		$user2 = new Cardmatch_User();
		$user2->setFirstName('JESSIE');
		$user2->setMiddleInitial('');
		$user2->setLastName('SINGDOM');
		$user2->setStreetAddress('937 HEAVEN');
		$user2->setCity('FANTASY ISLAND');
		$user2->setState('IL');
		$user2->setZipCode('60750');
		$user2->setSSN('666458535');

		$user3 = new Cardmatch_User();
		$user3->setFirstName('IMA');
		$user3->setMiddleInitial('');
		$user3->setLastName('ZUMA');
		$user3->setStreetAddress('123 MAIN');
		$user3->setCity('FANTASY ISLAND');
		$user3->setState('IL');
		$user3->setZipCode('60750');
		$user3->setSSN('666202020');

		$user4 = new Cardmatch_User();
		$user4->setFirstName('ZULU');
		$user4->setMiddleInitial('X');
		$user4->setLastName('ZIPPY');
		$user4->setStreetAddress('27 CAROL');
		$user4->setCity('FANTASY ISLAND');
		$user4->setState('IL');
		$user4->setZipCode('60750');
		$user4->setSSN('666668888');

		$user5 = new Cardmatch_User();
		$user5->setFirstName('BRADFORD');
		$user5->setMiddleInitial('L');
		$user5->setLastName('ZIEGLER');
		$user5->setStreetAddress('123 LAPMASTER');
		$user5->setCity('FANTASY ISLAND');
		$user5->setState('IL');
		$user5->setZipCode('60750');
		$user5->setSSN('666621243');

		$user6 = new Cardmatch_User();
		$user6->setFirstName('JOE');
		$user6->setMiddleInitial('');
		$user6->setLastName('YAGER');
		$user6->setStreetAddress('60 GOOD');
		$user6->setCity('FANTASY ISLAND');
		$user6->setState('IL');
		$user6->setZipCode('60750');
		$user6->setSSN('666072088');

		$user7 = new Cardmatch_User();
		$user7->setFirstName('JIM');
		$user7->setMiddleInitial('');
		$user7->setLastName('WYLIE');
		$user7->setStreetAddress('1971 SPRING');
		$user7->setCity('FANTASY ISLAND');
		$user7->setState('IL');
		$user7->setZipCode('60750');
		$user7->setSSN('666162545');

		$user8 = new Cardmatch_User();
		$user8->setFirstName('SUNNY');
		$user8->setMiddleInitial('');
		$user8->setLastName('WRIGHT');
		$user8->setStreetAddress('382 TRAVELERS');
		$user8->setCity('FANTASY ISLAND');
		$user8->setState('IL');
		$user8->setZipCode('60750');
		$user8->setSSN('666123789');

		$user9 = new Cardmatch_User();
		$user9->setFirstName('ANNA');
		$user9->setMiddleInitial('M');
		$user9->setLastName('WONG');
		$user9->setStreetAddress('1800 WENTWORTH');
		$user9->setCity('FANTASY ISLAND');
		$user9->setState('IL');
		$user9->setZipCode('60750');
		$user9->setSSN('666083181');

		$user10 = new Cardmatch_User();
		$user10->setFirstName('DAISY');
		$user10->setMiddleInitial('M');
		$user10->setLastName('YOKUM');
		$user10->setStreetAddress('555 W ADAMS ST');
		$user10->setCity('FANTASY ISLAND');
		$user10->setState('IL');
		$user10->setZipCode('60750');
		$user10->setSSN('666221255');

		$user11 = new Cardmatch_User();
		$user11->setFirstName('BOOGIE');
		$user11->setMiddleInitial('');
		$user11->setLastName('WOOGIE');
		$user11->setStreetAddress('444 MICHIGAN');
		$user11->setCity('FANTASY ISLAND');
		$user11->setState('IL');
		$user11->setZipCode('60750');
		$user11->setSSN('666603390');

		$user12 = new Cardmatch_User();
		$user12->setFirstName('DISNEY');
		$user12->setMiddleInitial('');
		$user12->setLastName('WORLD');
		$user12->setStreetAddress('4323 MICKEY');
		$user12->setCity('FANTASY ISLAND');
		$user12->setState('IL');
		$user12->setZipCode('60750');
		$user12->setSSN('666701234');

		$user13 = new Cardmatch_User();
		$user13->setFirstName('CAB');
		$user13->setMiddleInitial('');
		$user13->setLastName('YELLOW');
		$user13->setStreetAddress('512 TAXI');
		$user13->setCity('FANTASY ISLAND');
		$user13->setState('IL');
		$user13->setZipCode('60750');
		$user13->setSSN('666326587');

		$user14 = new Cardmatch_User();
		$user14->setFirstName('SIDNEY');
		$user14->setMiddleInitial('');
		$user14->setLastName('YATES');
		$user14->setStreetAddress('352 LOVERS');
		$user14->setCity('FANTASY ISLAND');
		$user14->setState('IL');
		$user14->setZipCode('60750');
		$user14->setSSN('666889989');

		$user15 = new Cardmatch_User();
		$user15->setFirstName('ALICE');
		$user15->setMiddleInitial('');
		$user15->setLastName('WONDER');
		$user15->setStreetAddress('2173 WHITAKER');
		$user15->setCity('FANTASY ISLAND');
		$user15->setState('IL');
		$user15->setZipCode('60750');
		$user15->setSSN('666820933');

		$user16 = new Cardmatch_User();
		$user16->setFirstName('NATHAN');
		$user16->setMiddleInitial('N');
		$user16->setLastName('WINTER');
		$user16->setStreetAddress('1625 POWDER HORN');
		$user16->setCity('FANTASY ISLAND');
		$user16->setState('IL');
		$user16->setZipCode('60750');
		$user16->setSSN('666444430');

		$user17 = new Cardmatch_User();
		$user17->setFirstName('JOE');
		$user17->setMiddleInitial('M');
		$user17->setLastName('WHITE');
		$user17->setStreetAddress('404 CANAL');
		$user17->setCity('FANTASY ISLAND');
		$user17->setState('IL');
		$user17->setZipCode('60750');
		$user17->setSSN('666859001');

		$user18 = new Cardmatch_User();
		$user18->setFirstName('POWER');
		$user18->setMiddleInitial('');
		$user18->setLastName('TOOL');
		$user18->setStreetAddress('812 BLACKDECKER');
		$user18->setCity('FANTASY ISLAND');
		$user18->setState('IL');
		$user18->setZipCode('60750');
		$user18->setSSN('666348909');

		$user19 = new Cardmatch_User();
		$user19->setFirstName('HAROLD');
		$user19->setMiddleInitial('');
		$user19->setLastName('TOWN');
		$user19->setStreetAddress('100 MORRIS');
		$user19->setCity('FANTASY ISLAND');
		$user19->setState('IL');
		$user19->setZipCode('60750');
		$user19->setSSN('666012009');

		$user20 = new Cardmatch_User();
		$user20->setFirstName('KINDERGARTEN');
		$user20->setMiddleInitial('');
		$user20->setLastName('TEACHER');
		$user20->setStreetAddress('427 LEARN');
		$user20->setCity('FANTASY ISLAND');
		$user20->setState('IL');
		$user20->setZipCode('60750');
		$user20->setSSN('666228878');

		$user21 = new Cardmatch_User();
		$user21->setFirstName('LOUIS');
		$user21->setMiddleInitial('');
		$user21->setLastName('AMACOMMON');
		$user21->setStreetAddress('11 99TH');
		$user21->setCity('FANTASY ISLAND');
		$user21->setState('IL');
		$user21->setZipCode('60750');
		$user21->setSSN('666480031');

		//removed user9 from the list for this round
		$testUsers = array($user1, $user2, $user3, $user4, $user5, $user6, $user7, $user8, $user9, $user10,
			$user11, $user12, $user13, $user14, $user15, $user16, $user17, $user18, $user19,
			$user20, $user21,);

		return $testUsers;
	}

	function getTestUsers() {

		return $this->_createTestUsers();
	}
}
