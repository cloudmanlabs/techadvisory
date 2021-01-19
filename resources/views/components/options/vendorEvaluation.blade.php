@props(['selected'])

<option value="-1">-- Evaluation --</option>

<option value="0" {{in_array('0', $selected) ? 'selected' : ''}}>not existing</option>
<option value="2" {{in_array('2', $selected) ? 'selected' : ''}}>existing but too weak</option>
<option value="4" {{in_array('4', $selected) ? 'selected' : ''}}>not satisfied / not efficient</option>
<option value="6" {{in_array('6', $selected) ? 'selected' : ''}}>satisfied / acceptable</option>
<option value="8" {{in_array('8', $selected) ? 'selected' : ''}}>very satisfied / efficient</option>
<option value="10" {{in_array('10', $selected) ? 'selected' : ''}}>extremely satisfied / succeeds expectations</option>
