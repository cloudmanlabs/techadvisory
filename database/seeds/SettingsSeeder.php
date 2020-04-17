<?php

use Illuminate\Database\Seeder;

use OptimistDigital\NovaSettings\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Settings([
            'key' => 'client_firstLogin',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'client_Home',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'client_ProfileCreate',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'client_Profile',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_firstLogin',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_Home',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_Profile',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_ProfileCreate',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_SolutionsHome',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'accenture_Home',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'accenture_NewProjectSetUp',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'accenture_ValueTargeting',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'accenture_Conclusions',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'client_NewProjectSetUp',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'client_Conclusions',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
        (new Settings([
            'key' => 'vendor_NewApplication',
            'value' => 'https://www.youtube.com/embed/IHjNcp_4QCs'
        ]))->save();
    }
}
