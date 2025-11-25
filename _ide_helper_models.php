<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string|null $desa
 * @property string $kecamatan
 * @property string|null $site
 * @property string $lokasi_blankspot
 * @property string|null $layanan_pendidikan
 * @property string|null $layanan_kesehatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereLayananKesehatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereLayananPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereLokasiBlankspot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blankspot whereUpdatedAt($value)
 */
	class Blankspot extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode
 * @property string $provider
 * @property string $kelurahan
 * @property string $kecamatan
 * @property string $alamat
 * @property string $longitude
 * @property string $latitude
 * @property string $status
 * @property int $tinggi_tower
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereKelurahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereTinggiTower($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataMenara whereUpdatedAt($value)
 */
	class DataMenara extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_tempat
 * @property string $alamat
 * @property string $tahun
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereNamaTempat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HotspotData whereUpdatedAt($value)
 */
	class HotspotData extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_dokumen
 * @property string $file_path
 * @property string $nama_file_asli
 * @property int $view_count
 * @property int $download_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereNamaDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereNamaFileAsli($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulasi whereViewCount($value)
 */
	class Regulasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

