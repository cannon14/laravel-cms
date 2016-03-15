<?php

class Cardmatch_Client_TransUnion_ResponseBuilder {


	/**
	 * @param $responseString
	 *
	 * @return Cardmatch_Client_TransUnion_Response
	 */
	public function parseResponse($responseString) {

		$responseSegments = $this->parseSegments($responseString);
		$buckets = array();
		$errorCode = '';
		$responseId = '';

		$responseExternalVisitId = "";

		foreach ($responseSegments as $segment) {

			$prefix = $segment->getPrefix();
			$data = $segment->getData();

			switch($prefix) {
				case "TU4E":
					$responseId = substr($data, 3, 24);
					break;

				case "TU4R":
					$responseId = substr($data, 3, 24);  // 24-byte at offset 11
					break;

				case "DI01":
					$responseExternalVisitId .= substr($data, 2, 24);  // 24-byte at offset 10
					break;

				case "DR01":
					$approved = substr($data, 12, 1);  // 1-byte at offset 20
					if ($approved == "A") {
						$bucketId = rtrim(substr($data, 170, 6)); // 6-bytes at offset 178
						$buckets[] = $bucketId; // store raw buckets to surface for testing script
					}
					if ($approved == "X") {
						$errorCode = 'NCBH';
					}
					break;

				case "ERRC":
					$errorCode = substr($data, 1, 3);
					break;
			}
		}

		$responseExternalVisitId = rtrim($responseExternalVisitId," ");

		$response = new Cardmatch_Client_TransUnion_Response();

		$response->setErrorCode($errorCode);
		$response->setResponseId($responseId);
		$response->setExternalVisitId($responseExternalVisitId);
		$response->setApprovedBuckets($buckets);

		return $response;
	}

	/**
	 * @param $response
	 *
	 * @return Cardmatch_Client_TransUnion_Segment[]
	 */
	protected function parseSegments($response) {

		$segments = array();

		while (!empty($response)) {

			$prefixLength = 4; // The prefix is 4 chars, the length is 3 chars
			$prefix = substr($response, 0, $prefixLength);
			$length = intval(substr($response, $prefixLength, 3));

			if($length == 0) break;

			$dataOffset = $prefixLength + 3;
			$data = substr($response, $dataOffset, $length - $dataOffset);

			// eat this segment's length from responseString
			$response = substr($response, $length);

			$segments[] = new Cardmatch_Client_TransUnion_Segment($prefix, $length, $data);

			if ($prefix == "ENDS") break;
		}

		return $segments;
	}


}

