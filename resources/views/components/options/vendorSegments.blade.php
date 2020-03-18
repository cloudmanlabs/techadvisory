@props(['selected'])

<option value="megasuite" {{in_array('megasuite', $selected) ? 'selected' : ''}}>Megasuite</option>
<option value="scmsuite" {{in_array('scmsuite', $selected) ? 'selected' : ''}}>SCM suite</option>
<option value="specific" {{in_array('specific', $selected) ? 'selected' : ''}}>Specific solution</option>
