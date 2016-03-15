function validateCardMatch(form) {
	if (form.firstName.value === 'First Name') {
		form.firstName.value = '';
	}
	/*if (form.middleInitial.value === 'MI') {
		form.middleInitial.value = '';
	}*/
	if (form.lastName.value === 'Last Name') {
		form.lastName.value = '';
	}
}
