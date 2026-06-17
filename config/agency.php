<?php

$phoneNational = '5346187276';
$phoneE164 = '90'.$phoneNational;

return [
    'phone_national' => $phoneNational,
    'phone_display' => '+90 (534) 618 72 76',
    'phone_tel' => '+'.$phoneE164,
    'whatsapp_url' => 'https://wa.me/'.$phoneE164.'?text='.rawurlencode(
        'Merhaba, web sitenizden ulaşıyorum, hizmetleriniz hakkında bilgi almak istiyorum.'
    ),
    'email' => 'ensar.brahim@gmail.com',
];
