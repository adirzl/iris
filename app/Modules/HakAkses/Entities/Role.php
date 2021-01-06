<?php

namespace Modules\HakAkses\Entities;

use App\Concerns\TapActivity;
use Illuminate\Support\Facades\DB;

class Role extends \Spatie\Permission\Models\Role
{
    use TapActivity;

    /**
     * @var string
     */
    protected $roleHasModule = 'mst_role_has_module';

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules()
    {
        return $this->belongsToMany(\App\Entities\Module::class, $this->roleHasModule)
            ->orderByRaw('cast(sequence as float)');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $q = $query->select(['id', 'name'])
            ->orderBy('id');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $communityId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetCommunityRole($query, $communityId)
    {
        $community = DB::table('app_community')->where('id', $communityId)->first();

        if (is_null($community->community_id)) {
            $query->whereIn('name', ['MAKER PRINCIPAL', 'APPROVER PRINCIPAL']);
        } else {
            $query->whereIn('name', ['MAKER DISTRIBUTOR', 'APPROVER DISTRIBUTOR']);
        }

        return $query->get();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function scopeGetNewId($query)
    {
        $result = $query->select('id')->orderByDesc('id')->first();

        return ($result) ? $result->id + 1 : 99;
    }

    /**
     * @param int $id
     * @param array $modules
     * @return void
     */
    public static function syncModules(int $id, array $modules): void
    {
        $roleHasModuleTable = (new static)->roleHasModule;
        DB::table($roleHasModuleTable)->where('role_id', $id)->delete();
        collect($modules)->each(function ($item, $key) use ($id, $roleHasModuleTable) {
            DB::table($roleHasModuleTable)->insert(['role_id' => $id, 'module_id' => $item]);
        });
    }
}