<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * https://ibb.co.com/album/Xrh2V5
     */

    public function run(): void
    {
        $motors = [
<<<<<<< Updated upstream
            ['nama_motor' => 'Honda Beat', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1010 BT', 'image_url' => 'https://i.ibb.co.com/rRbwxgSx/New-Honda-Beat.webp'],
            ['nama_motor' => 'Honda Beat Street', 'tipe' => 'Matic', 'harga_per_hari' => 80000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1011 BS', 'image_url' => 'https://i.ibb.co.com/qLXgxVzL/Honda-Beat-Street.webp'],
            ['nama_motor' => 'Honda Vario 125', 'tipe' => 'Matic', 'harga_per_hari' => 85000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1012 VR', 'image_url' => 'https://i.ibb.co.com/P3W4PPs/Honda-Vario-125.webp'],
            ['nama_motor' => 'Honda Vario 160', 'tipe' => 'Matic', 'harga_per_hari' => 95000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1013 VV', 'image_url' => 'https://i.ibb.co.com/jPb6fwjG/Honda-Vario-160.jpg'],
            ['nama_motor' => 'Honda Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 85000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1014 SC', 'image_url' => 'https://i.ibb.co.com/8LqFPNKL/Honda-Scoopy.jpg'],
            ['nama_motor' => 'Honda Genio', 'tipe' => 'Matic', 'harga_per_hari' => 80000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1015 GN', 'image_url' => 'https://i.ibb.co.com/4HDRdcr/Honda-Genio.webp'],
            ['nama_motor' => 'Honda PCX 160', 'tipe' => 'Matic', 'harga_per_hari' => 130000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1016 PX', 'image_url' => 'https://i.ibb.co.com/Ldbw0bPp/Honda-PCX-160.jpg'],
            ['nama_motor' => 'Honda Stylo 160', 'tipe' => 'Matic', 'harga_per_hari' => 100000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1032 ST', 'image_url' => 'https://i.ibb.co.com/W4NW8fv3/Honda-Stylo-160.jpg'],
            ['nama_motor' => 'Yamaha NMAX 155', 'tipe' => 'Matic', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1033 NM', 'image_url' => 'https://i.ibb.co.com/JFxbfxhZ/Yamaha-NMAX-155.jpg'],
            ['nama_motor' => 'Yamaha Aerox 155', 'tipe' => 'Matic', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1034 AY', 'image_url' => 'https://i.ibb.co.com/1BbkM67/Yamaha-Aerox-155.jpg'],
            ['nama_motor' => 'Honda ADV 160', 'tipe' => 'Matic', 'harga_per_hari' => 140000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1017 AD', 'image_url' => 'https://i.ibb.co.com/wZ3NL9P9/Honda-ADV-160.jpg'],
            ['nama_motor' => 'Yamaha Mio M3', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1021 MM', 'image_url' => 'https://i.ibb.co.com/ynYhjsSF/Yamaha-Mio-M3.png'],
            ['nama_motor' => 'Yamaha Fazzio', 'tipe' => 'Matic', 'harga_per_hari' => 90000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1022 FZ', 'image_url' => 'https://i.ibb.co.com/7BGLvg6/Yamaha-Fazzio.png'],
            ['nama_motor' => 'Yamaha Grand Filano', 'tipe' => 'Matic', 'harga_per_hari' => 95000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1023 GF', 'image_url' => 'https://i.ibb.co.com/Z6HGBmcQ/Yamaha-Grand-Filano.png'],
            ['nama_motor' => 'Yamaha Gear 125', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1024 GR', 'image_url' => 'https://i.ibb.co.com/Mxn1g0Nh/Yamaha-Gear-125.jpg'],
            ['nama_motor' => 'Yamaha Lexi LX 155', 'tipe' => 'Matic', 'harga_per_hari' => 110000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1025 LX', 'image_url' => 'https://i.ibb.co.com/8DpgQmJp/Yamaha-Lexi-LX-155.jpg'],
            ['nama_motor' => 'Vespa Primavera 150', 'tipe' => 'Matic', 'harga_per_hari' => 180000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1026 PM', 'image_url' => 'https://i.ibb.co.com/XxsRrhT1/Vespa-Primavera-150.webp'],
            ['nama_motor' => 'Vespa Sprint 150', 'tipe' => 'Matic', 'harga_per_hari' => 190000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1027 SP', 'image_url' => 'https://i.ibb.co.com/5xt0VRPX/Vespa-Sprint-150.png'],
            ['nama_motor' => 'Vespa GTS Super 150', 'tipe' => 'Matic', 'harga_per_hari' => 220000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1028 GT', 'image_url' => 'https://i.ibb.co.com/1YsXM8x5/Vespa-GTS-Super-150.png'],
            ['nama_motor' => 'Vespa LX 125', 'tipe' => 'Matic', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1029 VL', 'image_url' => 'https://i.ibb.co.com/q3RRWdbQ/Vespa-LX-125.png'],
            ['nama_motor' => 'Suzuki Nex II', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1030 NX', 'image_url' => 'https://i.ibb.co.com/Z6PWkzdn/Suzuki-Nex-II.webp'],
            ['nama_motor' => 'Suzuki Address', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 1031 AD', 'image_url' => 'https://i.ibb.co.com/cKMRC4bj/Suzuki-Address.webp'],
            ['nama_motor' => 'Honda Supra X 125', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2010 SX', 'image_url' => 'https://i.ibb.co.com/s97q0jWt/Honda-Supra-X-125.webp'],
            ['nama_motor' => 'Honda Revo Fit', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 70000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2011 RF', 'image_url' => 'https://i.ibb.co.com/6cQWqg53/Honda-Revo-Fit.jpg'],
            ['nama_motor' => 'Honda Revo X', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2012 RX', 'image_url' => 'https://i.ibb.co.com/JRM3Mt7B/Honda-Revo-X.webp'],
            ['nama_motor' => 'Honda Supra GTR 150', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 95000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2013 SG', 'image_url' => 'https://i.ibb.co.com/4wSn87DB/Honda-Supra-GTR-150.jpg'],
            ['nama_motor' => 'Honda Sonic 150R', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 100000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2014 SO', 'image_url' => 'https://i.ibb.co.com/gMdFt8M5/Honda-Sonic-150-R.webp'],
            ['nama_motor' => 'Yamaha Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2015 VF', 'image_url' => 'https://i.ibb.co.com/6Rf4ChDY/Yamaha-Vega-Force.png'],
            ['nama_motor' => 'Yamaha Jupiter Z1', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 80000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2016 JZ', 'image_url' => 'https://i.ibb.co.com/JwcSsHgy/Yamaha-Jupiter-Z1.png'],
            ['nama_motor' => 'Yamaha MX King 150', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 100000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2017 MK', 'image_url' => 'https://i.ibb.co.com/SD1gc6MV/Yamaha-MX-King-150.png'],
            ['nama_motor' => 'Suzuki Smash FI', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 70000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2018 SM', 'image_url' => 'https://i.ibb.co.com/Psg8LvCk/Suzuki-Smash-FI.webp'],
            ['nama_motor' => 'Suzuki Satria F150', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 110000, 'status' => 'tersedia', 'plat_nomor' => 'AB 2019 SF', 'image_url' => 'https://i.ibb.co.com/2Hrm3mx/Suzuki-Satria-F150.webp'],
            ['nama_motor' => 'Honda CBR150R', 'tipe' => 'Sport', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3010 CB', 'image_url' => 'https://i.ibb.co.com/WN2KmmDS/Honda-CBR150-R.jpg'],
            ['nama_motor' => 'Honda CB150R Streetfire', 'tipe' => 'Sport', 'harga_per_hari' => 130000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3011 SF', 'image_url' => 'https://i.ibb.co.com/S4XfBxdf/Honda-CB150-R-Streetfire.jpg'],
            ['nama_motor' => 'Honda CB150X', 'tipe' => 'Sport', 'harga_per_hari' => 140000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3012 CX', 'image_url' => 'https://i.ibb.co.com/DHcbfSqH/Honda-CB150-X.webp'],
            ['nama_motor' => 'Honda CBR250RR', 'tipe' => 'Sport', 'harga_per_hari' => 250000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3013 CR', 'image_url' => 'https://i.ibb.co.com/9HQ96cF5/Honda-CBR250-RR.jpg'],
            ['nama_motor' => 'Yamaha YZF-R15', 'tipe' => 'Sport', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3014 YR', 'image_url' => 'https://i.ibb.co.com/VWcdBWpW/Yamaha-YZF-R15.jpg'],
            ['nama_motor' => 'Yamaha Vixion R', 'tipe' => 'Sport', 'harga_per_hari' => 120000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3015 VX', 'image_url' => 'https://i.ibb.co.com/8Lc7w33w/Yamaha-Vixion-R.jpg'],
            ['nama_motor' => 'Yamaha MT-15', 'tipe' => 'Sport', 'harga_per_hari' => 140000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3016 MT', 'image_url' => 'https://i.ibb.co.com/VY4DY58r/Yamaha-MT-15.png'],
            ['nama_motor' => 'Yamaha YZF-R25', 'tipe' => 'Sport', 'harga_per_hari' => 240000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3017 YZ', 'image_url' => 'https://i.ibb.co.com/8gN1KTM5/Yamaha-YZF-R25.png'],
            ['nama_motor' => 'Suzuki GSX-R150', 'tipe' => 'Sport', 'harga_per_hari' => 130000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3018 GS', 'image_url' => 'https://i.ibb.co.com/gbRhR4pm/Suzuki-GSX-R150.webp'],
            ['nama_motor' => 'Suzuki GSX-S150', 'tipe' => 'Sport', 'harga_per_hari' => 120000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3019 SS', 'image_url' => 'https://i.ibb.co.com/G322bYmT/Suzuki-GSX-S150.png'],
            ['nama_motor' => 'Kawasaki Ninja 250', 'tipe' => 'Sport', 'harga_per_hari' => 250000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3020 NJ', 'image_url' => 'https://i.ibb.co.com/X9hhgLn/Kawasaki-Ninja-250.jpg'],
            ['nama_motor' => 'Kawasaki W175', 'tipe' => 'Sport', 'harga_per_hari' => 140000, 'status' => 'tersedia', 'plat_nomor' => 'AB 3021 WK', 'image_url' => 'https://i.ibb.co.com/wZnYRV1p/Kawasaki-W175.jpg'],
            ['nama_motor' => 'Honda CRF150L', 'tipe' => 'Trail', 'harga_per_hari' => 150000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4010 CF', 'image_url' => 'https://i.ibb.co.com/QFNqK5g6/Honda-CRF150-L.jpg'],
            ['nama_motor' => 'Yamaha WR155R', 'tipe' => 'Trail', 'harga_per_hari' => 160000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4011 WR', 'image_url' => 'https://i.ibb.co.com/0VDwGzyF/Yamaha-WR155-R.webp'],
            ['nama_motor' => 'Kawasaki KLX 150', 'tipe' => 'Trail', 'harga_per_hari' => 140000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4012 KX', 'image_url' => 'https://i.ibb.co.com/hFsKRC4P/Kawasaki-KLX-150.jpg'],
            ['nama_motor' => 'Kawasaki KLX 230', 'tipe' => 'Trail', 'harga_per_hari' => 200000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4013 KL', 'image_url' => 'https://i.ibb.co.com/svK1ZrQL/Kawasaki-KLX-230.jpg'],
            ['nama_motor' => 'Kawasaki D-Tracker 150', 'tipe' => 'Trail', 'harga_per_hari' => 145000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4014 DT', 'image_url' => 'https://i.ibb.co.com/rgs9zgX/Kawasaki-D-Tracker-150.jpg'],
            ['nama_motor' => 'Honda CRF250 Rally', 'tipe' => 'Trail', 'harga_per_hari' => 250000, 'status' => 'tersedia', 'plat_nomor' => 'AB 4015 RY', 'image_url' => 'https://i.ibb.co.com/Txrb8Cfz/Honda-CRF250-Rally.webp'],
=======
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9001 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9002 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9003 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9004 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9005 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9006 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9007 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9008 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9009 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9010 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9011 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9012 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
>>>>>>> Stashed changes
        ];
        foreach ($motors as $motor) {
            \App\Models\Product::updateOrCreate(
                ['nama_motor' => $motor['nama_motor']],
                $motor
            );
        }
    }
}
