jQuery.validator.addMethod("regex", function(value, element, param) {
	var numberRegex;

	switch(param[0]){
	case "name":
		numberRegex = /^[a-zA-Z \.\(\)\']{0,50}$/;
		break;
	case "clientname":
		numberRegex = /^[a-zA-Z0-9, \/\-\.\\&\,\*']{0,150}$/;
		break;	
	case "time":
		numberRegex = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
		break;
	case "entity_name":
		numberRegex = /^[a-zA-Z0-9 \.\']{0,50}$/;
		break;
	case "digits":		
		numberRegex = /^\d+(?:\.\d+)?$/;
		break;
	case "film":
		numberRegex = /^[a-zA-Z0-9, \/\-\.\\&\,\*']{0,150}$/;
		break;	
	case "address":
		numberRegex = /^[a-zA-Z0-9, \/\-\.\']{10,150}$/;
		break;
	case "client-group":
		numberRegex = /^[a-zA-Z0-9 \-\.]{0,50}$/;
		break;
	case "location":
		numberRegex = /^[a-zA-Z ]{2,50}$/;
		break;
	case "landline":
		numberRegex = /^[0-9 \-]{0,15}$/;
		break;
	case "floatdigit":
		numberRegex = /^\d+(?:\.\d+)?$/;
		break;
	case "pan-card":
		numberRegex = /^[a-zA-Z]{5}\d{4}[a-zA-Z]{1}$/;
		break;
	case "alnum":
		numberRegex = /^[a-zA-Z0-9]+$/;
		break;
	case "title":
		numberRegex = /^[a-zA-Z0-9, \/\-\.\\&\,\*\?\(\)\!\']{0,150}$/;
		//numberRegex = /^[a-zA-Z0-9, \/\-\.\\&\,\*\`\�\:\#\?\(\)\!\']{0,150}$/;
	break;
	case "titlename":
		numberRegex = /^[a-zA-Z0-9, \/\-\.\\&\,\*\`\�\:\#\_\<\>\{\}\[\]\^\$\%\@\;\|\+\=\"\?\(\)\!\']{0,150}$/;
	break;
	default:
		numberRegex = param[0];
		break;		
	}
	return numberRegex.test(value);
},"Invalid {1}");
