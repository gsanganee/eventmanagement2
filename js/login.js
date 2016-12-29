// JavaScript validation of subscription form.
// A. Anonymous function triggered by submit event
// B. Functions called to perform generic checks by anon function in section A
// C. Functions to get / set / show / remove error messages


// Dependencies: jQuery, jQueryUI, styles.css

(function () {

  // -------------------------------------------------------------------------
  //  A) ANONYMOUS FUNCTION TRIGGERERD BY THE SUBMIT EVENT
  // -------------------------------------------------------------------------
  $('#form').on('submit', function (e) {      // When form is submitted
    e.preventDefault();                       // Prevent form being submitted

    var elements = this.elements;            // Collection of form controls
    var valid = {};                          // Custom valid object
    var isValid;                             // isValid: checks form controls
    var isFormValid;                         // isFormValid: checks entire form
    var url = "login-submit.php";

    console.log("submitted");

    // PERFORM GENERIC CHECKS (calls functions outside the event handler)
    var i;
    for (i = 0, l = elements.length; i < l; i++) {
      // Next line calls validateRequired()
      isValid = validateRequired(elements[i]);
      if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(elements[i]);   // Show error messages
      } else {                           // Otherwise
        removeErrorMessage(elements[i]); // Remove error messages
      }                                  // End if statement
      valid[elements[i].id] = isValid;   // Add element to the valid object

    }                                    // End for loop
    console.log("Checked required elements");

    // PERFORM CUSTOM VALIDATION
    // password (you could cache password input in variable here)
    if (!validatePassword()) {          // Call validatePassword(), and if not valid
      showErrorMessage(document.getElementById('password')); // Show error message
      valid.password = false;           // Update the valid object - this element is not valid
    } else {                            // Otherwise remove error message
      removeErrorMessage(document.getElementById('password'));
    }

    console.log("Checked password");

    // DID IT PASS / CAN IT SUBMIT THE FORM?
    // Loop through valid object, if there are errors set isFormValid to false
    for (var field in valid) {          // Check properties of the valid object
      if (!valid[field]) {              // If it is not valid
        isFormValid = false;            // Set isFormValid variable to false
        break;                          // Stop the for loop, an error was found
      }                                 // Otherwise

      // Everything entered was valid.
      isFormValid = true;               // The form is valid and OK to submit
    }

    // If the form did not validate, prevent it being submitted
    if (!isFormValid) {                 // If isFormValid is not true
      e.preventDefault();               // Prevent the form being submitted
    }


    // If validation succeeded
    // Use ajax call to check whether user exists on server

    if (isFormValid) {

      // Format the form input fields so that they
      // can be passed to the PHP web service.

      var parameters = $('form').serialize();

      // Now make ajax call to PHP web service
      // We want JSON returned.
      $.ajax({
        dataType: "json",
        url: url,
        data: parameters
      }).done(function(responseText) {
            // Remove the login form completely
            $('fieldset').remove();
            // Show a "Welcome" message
            window.open ('wbst.html');

      }).fail(function() {
            console.log("failed to find username");
            var el = document.getElementById('password'); // changed from username to password to make "invalid user name or password" appear below password
            setErrorMessage(el,  'Invalid username or password. Try again.');  // Set the error
            showErrorMessage(el); // Show error message
      });


    }

  });                                   // End of event handler anon function
  //  END: anonymous function triggered by the submit button


  // -------------------------------------------------------------------------
  // B) FUNCTIONS FOR GENERIC CHECKS
  // -------------------------------------------------------------------------

  // CHECK IF THE FIELD IS REQUIRED AND IF SO DOES IT HAVE A VALUE
  // Relies on isRequired() and isEmpty() both shown below, and setErrorMessage - shown later.
  function validateRequired(el) {
    if (isRequired(el)) {                           // Is this element required?
      var valid = !isEmpty(el);                     // Is value not empty (true / false)?
      if (!valid) {                                 // If valid variable holds false
        setErrorMessage(el,  'Field is required');  // Set the error message
      }
      return valid;                                 // Return valid variable (true or false)?
    }
    return true;                                    // If not required, all is ok
  }

  // CHECK IF THE ELEMENT IS REQUIRED
  // It is called by validateRequired()
  function isRequired(el) {
   return ((typeof el.required === 'boolean') && el.required) ||
     (typeof el.required === 'string');
  }

  // CHECK IF THE ELEMENT IS EMPTY (or its value is the same as the placeholder text)
  // HTML5 browsers do allow users to enter the same text as placeholder, but in this case users should not need to
  // It is called by validateRequired()
  function isEmpty(el) {
    return !el.value || el.value === el.placeholder;
  }

  // Check that the password is 8 characters or more
  function validatePassword() {
    var password = document.getElementById('password');
    var valid = password.value.length >= 8;
    if (!valid) {
      setErrorMessage(password, 'Password must be at least 8 characters');
    }
    return valid;
  }



  // -------------------------------------------------------------------------
  // C) FUNCTIONS TO SET / GET / SHOW / REMOVE ERROR MESSAGES
  // -------------------------------------------------------------------------

  function setErrorMessage(el, message) {
    $(el).data('errorMessage', message);                 // Store error message with element
  }

  function getErrorMessage(el) {
    return $(el).data('errorMessage') || el.title;       // Get error message or title of element
  }

  function showErrorMessage(el) {
    var $el = $(el);                                     // The element with the error
    var errorContainer = $el.siblings('.error.message'); // Any siblings holding an error message

    if (!errorContainer.length) {                         // If no errors exist with the element
       // Create a <span> element to hold the error and add it after the element with the error
       errorContainer = $('<span class="error message"></span>').insertAfter($el);
    }
    errorContainer.text(getErrorMessage(el));             // Add error message
  }

  function removeErrorMessage(el) {
    var errorContainer = $(el).siblings('.error.message'); // Get the sibling of this form control used to hold the error message
    errorContainer.remove();                               // Remove the element that contains the error message
  }

}());  // End of IIFE
