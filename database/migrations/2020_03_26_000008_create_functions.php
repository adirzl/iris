<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE OR REPLACE FUNCTION "public"."merge_aplikasi"()
  RETURNS "pg_catalog"."numeric" AS $BODY$ 
DECLARE affected_rows NUMERIC;
BEGIN
	affected_rows := 0;
	INSERT INTO app_reg_aplikasi (id, idaplikasi, nama, keterangan, alamat, ada_limit, akses, muncul_di_uim, sinkronisasi, created_at, updated_at) 
		SELECT 
			uuid_generate_v4(), uim_aplikasi.id, uim_aplikasi.nama, uim_aplikasi.keterangan, uim_aplikasi.alamat, 
			uim_aplikasi.ada_limit, uim_aplikasi.akses, uim_aplikasi.muncul_di_uim, \'t\', NOW(), NOW() 
		FROM uim_aplikasi 
		ON CONFLICT (idaplikasi) DO UPDATE SET 
			nama = EXCLUDED.nama, alamat = EXCLUDED.alamat, ada_limit = EXCLUDED.ada_limit, 
			akses = EXCLUDED.akses, muncul_di_uim = EXCLUDED.muncul_di_uim;
	GET DIAGNOSTICS affected_rows = ROW_COUNT;
	RETURN affected_rows;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100');

        DB::statement('CREATE OR REPLACE FUNCTION "public"."merge_aplikasi_fungsi"()
  RETURNS "pg_catalog"."numeric" AS $BODY$ 
DECLARE affected_rows NUMERIC;
BEGIN
	affected_rows := 0;
	INSERT INTO app_reg_aplikasi_fungsi (
		id, reg_aplikasi_id, idfungsi, nama, menu, status, limit_debit, limit_kredit, spv, akses1, akses2, sinkronisasi, created_at, updated_at
	) 
		SELECT 
			uuid_generate_v4(), ara.id, uaf.id, uaf.nama, uaf.menu, uaf.status, uaf.limit_debit, uaf.limit_kredit, 
			uaf.spv, uaf.akses1, uaf.akses2, \'t\', NOW(), NOW() 
		FROM uim_aplikasi_fungsi uaf 
		INNER JOIN app_reg_aplikasi ara ON uaf.idaplikasi = ara.idaplikasi
		ON CONFLICT (idfungsi) DO UPDATE SET 
			nama = EXCLUDED.nama, menu = EXCLUDED.menu, status = EXCLUDED.status, 
			limit_debit = EXCLUDED.limit_debit, limit_kredit = EXCLUDED.limit_kredit, 
			spv = EXCLUDED.spv, akses1 = EXCLUDED.akses1, akses2 = EXCLUDED.akses2;
	GET DIAGNOSTICS affected_rows = ROW_COUNT;
	RETURN affected_rows;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP FUNCTION IF EXISTS merge_aplikasi_fungsi()');
        DB::statement('DROP FUNCTION IF EXISTS merge_aplikasi()');
    }
}
