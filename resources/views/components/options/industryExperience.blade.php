@props(['selected'])

<option disabled {{count($selected)  == 0 ? 'selected' : ''}}>
    Please select the range
</option>

<option value="automative" {{in_array('automative', $selected) ? 'selected' : ''}}>
    Automative
</option>
<option value="consumer" {{in_array('consumer', $selected) ? 'selected' : ''}}>
    Consumer goods & services
</option>
<option value="industrial" {{in_array('industrial', $selected) ? 'selected' : ''}}>
    Industrial Equipement
</option>
<option value="life" {{in_array('life', $selected) ? 'selected' : ''}}>
    Life Sciences
</option>
<option value="retail" {{in_array('retail', $selected) ? 'selected' : ''}}>
    Retail
</option>
<option value="transport" {{in_array('transport', $selected) ? 'selected' : ''}}>
    Transport services
</option>
<option value="travel" {{in_array('travel', $selected) ? 'selected' : ''}}>
    Travel
</option>
<option value="chemical" {{in_array('chemical', $selected) ? 'selected' : ''}}>
    Chemical
</option>
<option value="energy" {{in_array('energy', $selected) ? 'selected' : ''}}>
    Energy
</option>
<option value="natural" {{in_array('natural', $selected) ? 'selected' : ''}}>
    Natural Resources
</option>
<option value="utilities" {{in_array('utilities', $selected) ? 'selected' : ''}}>
    Utilities
</option>
<option value="communications" {{in_array('communications', $selected) ? 'selected' : ''}}>
    Communications & Media
</option>
<option value="high" {{in_array('high', $selected) ? 'selected' : ''}}>
    High tech
</option>
<option value="cmt" {{in_array('cmt', $selected) ? 'selected' : ''}}>
    CMT SW&P
</option>
<option value="health" {{in_array('health', $selected) ? 'selected' : ''}}>
    Health
</option>
<option value="public" {{in_array('public', $selected) ? 'selected' : ''}}>
    Public Service
</option>
<option value="banking" {{in_array('banking', $selected) ? 'selected' : ''}}>
    Banking
</option>
<option value="capital" {{in_array('capital', $selected) ? 'selected' : ''}}>
    Capital Markets
</option>
<option value="insurance" {{in_array('insurance', $selected) ? 'selected' : ''}}>
    Insurance
</option>
