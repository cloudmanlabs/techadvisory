@props(['selected'])

<option disabled {{count($selected)  == 0 ? 'selected' : ''}}>
    Please select the range
</option>

<option value="worldwide" {{in_array('worldwide', $selected) ? 'selected' : ''}}>
    Worldwide
</option>
<option value="emea" {{in_array('emea', $selected) ? 'selected' : ''}}>
    EMEA
</option>
<option value="apac" {{in_array('apac', $selected) ? 'selected' : ''}}>
    APAC
</option>
<option value="na" {{in_array('na', $selected) ? 'selected' : ''}}>
    NA
</option>
<option value="latam" {{in_array('latam', $selected) ? 'selected' : ''}}>
    LATAM
</option>
