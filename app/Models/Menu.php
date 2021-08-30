<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'order',
        'parent_id',
        'enabled',
    ];


    /**
     * Get all of the childs for the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }


    /**
     * The users that belong to the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'menu_user', 'menu_id', 'user_id')->withTimestamps();
    }


    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent_id']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }


    public function optionsMenu()
    {
        return $this->where('enabled', 1)
            ->whereNotNull('parent_id')
            ->orderby('parent_id')
            ->orderby('order')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public function optionsUserMenu($user_id)
    {
        return $this->where('enabled', 1)
            ->whereNull('parent_id')
            ->whereHas('users', function (Builder $query) use($user_id) {
                $query->where( 'user_id', '=', $user_id );
            })
            ->orderby('order')
            ->orderby('name')
            ->get()
            ->toArray();
    }


    public static function menus($user_id = null)
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $dataUser = $menus->optionsUserMenu($user_id);
        $menuAll = [];
        foreach ($dataUser as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }

}
