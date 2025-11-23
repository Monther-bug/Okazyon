import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Seller/**/*.php',
        './resources/views/filament/seller/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
