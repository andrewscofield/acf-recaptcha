<?php
add_action('admin_menu', 'acf_recaptcha_add_admin_menu');
add_action('admin_init', 'acf_recaptcha_settings_init');


function acf_recaptcha_add_admin_menu()
{
    add_options_page(__('ACF reCAPTCHA', 'acf-recaptcha'), __('ACF reCAPTCHA', 'acf-recaptcha'), 'manage_options', 'acf_recaptcha', 'acf_recaptcha_options_page');
}


function acf_recaptcha_settings_init()
{
    register_setting('acf_recaptcha_settings', 'acf_recaptcha');

    add_settings_section(
        'acf_recaptcha_settings_section',
        __('reCAPTCHA Keys', 'acf-recaptcha'),
        'acf_recaptcha_settings_section_callback',
        'acf_recaptcha_settings'
    );

    add_settings_field(
        'site_key',
        __('Enter your site key from Google reCAPTCHA.', 'acf-recaptcha'),
        'site_key_render',
        'acf_recaptcha_settings',
        'acf_recaptcha_settings_section'
    );

    add_settings_field(
        'secret_key',
        __('Enter your secret key from Google reCAPTCHA.', 'acf-recaptcha'),
        'secret_key_render',
        'acf_recaptcha_settings',
        'acf_recaptcha_settings_section'
    );


}


function site_key_render()
{
    $options = get_option('acf_recaptcha');
    echo '<input type="text" name="acf_recaptcha[site_key]" value="'.$options['site_key'].'">';
}


function secret_key_render()
{
    $options = get_option('acf_recaptcha');
    echo '<input type="text" name="acf_recaptcha[secret_key]" value="'.$options['secret_key'].'">';
}


function acf_recaptcha_settings_section_callback()
{
    $link = '<a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA Dashboard</a>';
    printf(__('Go to the %s to generate your Site Key and Secret Key, then enter them here.', 'acf-recaptcha'), $link);
}


function acf_recaptcha_options_page()
{
    echo '
    <form action="options.php" method="post">
        <h1>'.__('ACF ReCaptcha Settings', 'acf-recaptcha').'</h1>';
    settings_fields('acf_recaptcha_settings');
    do_settings_sections('acf_recaptcha_settings');
    submit_button();
    echo '
    </form>';
}


function acf_recaptcha_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=acf-recaptcha">'.__('Settings', 'acf-recaptcha').'</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter("plugin_action_links_advanced-custom-fields-recaptcha-field/acf-recaptcha.php", "acf_recaptcha_add_settings_link");