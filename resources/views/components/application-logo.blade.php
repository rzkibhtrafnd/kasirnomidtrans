@if($setting && $setting->img_logo)
    <img src="{{ asset('storage/settings/' . $setting->img_logo) }}" {{ $attributes->merge(['class' => 'h-12 w-auto']) }} alt="Logo {{ $setting->company_name }}">
@else
    <div {{ $attributes->merge(['class' => 'font-bold text-xl text-blue-600']) }}>
        {{ $setting->company_name ?? 'Cashly' }}
    </div>
@endif