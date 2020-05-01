@props(['selected'])

<option disabled {{strlen($selected)  == 0 ? 'selected' : ''}}>
    Please select the range
</option>

<option value="automative" {{('automative' == $selected) ? 'selected' : ''}}>
    Automative
</option>
<option value="consumer" {{('consumer' == $selected) ? 'selected' : ''}}>
    Consumer goods & services
</option>
<option value="industrial" {{('industrial' == $selected) ? 'selected' : ''}}>
    Industrial Equipement
</option>
<option value="life" {{('life' == $selected) ? 'selected' : ''}}>
    Life Sciences
</option>
<option value="retail" {{('retail' == $selected) ? 'selected' : ''}}>
    Retail
</option>
<option value="transport" {{('transport' == $selected) ? 'selected' : ''}}>
    Transport services
</option>
<option value="travel" {{('travel' == $selected) ? 'selected' : ''}}>
    Travel
</option>
<option value="chemical" {{('chemical' == $selected) ? 'selected' : ''}}>
    Chemical
</option>
<option value="energy" {{('energy' == $selected) ? 'selected' : ''}}>
    Energy
</option>
<option value="natural" {{('natural' == $selected) ? 'selected' : ''}}>
    Natural Resources
</option>
<option value="utilities" {{('utilities' == $selected) ? 'selected' : ''}}>
    Utilities
</option>
<option value="communications" {{('communications' == $selected) ? 'selected' : ''}}>
    Communications & Media
</option>
<option value="high" {{('high' == $selected) ? 'selected' : ''}}>
    High tech
</option>
<option value="cmt" {{('cmt' == $selected) ? 'selected' : ''}}>
    CMT SW&P
</option>
<option value="health" {{('health' == $selected) ? 'selected' : ''}}>
    Health
</option>
<option value="public" {{('public' == $selected) ? 'selected' : ''}}>
    Public Service
</option>
<option value="banking" {{('banking' == $selected) ? 'selected' : ''}}>
    Banking
</option>
<option value="capital" {{('capital' == $selected) ? 'selected' : ''}}>
    Capital Markets
</option>
<option value="insurance" {{('insurance' == $selected) ? 'selected' : ''}}>
    Insurance
</option>
