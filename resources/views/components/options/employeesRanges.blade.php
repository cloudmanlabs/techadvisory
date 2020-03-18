@props(['selected'])

<option disabled {{count($selected)  == 0 ? 'selected' : ''}}>
    Please select the range
</option>
<option value="50" {{in_array('50', $selected) ? 'selected' : ''}}>
    0-50
</option>
<option value="500" {{in_array('500', $selected) ? 'selected' : ''}}>
    50-500
</option>
<option value="5000" {{in_array('5000', $selected) ? 'selected' : ''}}>
    500-5.000
</option>
<option value="30000" {{in_array('30000', $selected) ? 'selected' : ''}}>
    5.000 – 30.000
</option>
<option value="more" {{in_array('more', $selected) ? 'selected' : ''}}>
    + 30.000
</option>
