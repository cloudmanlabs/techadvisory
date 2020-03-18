@props(['selected'])

<option value="1" {{in_array('1', $selected) ? 'selected' : ''}}>Vendor 1</option>
<option value="2" {{in_array('2', $selected) ? 'selected' : ''}}>Vendor 2</option>
<option value="3" {{in_array('3', $selected) ? 'selected' : ''}}>Vendor 3</option>
