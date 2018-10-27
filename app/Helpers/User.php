<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class User {
    public static function getUserId( $user )
    {
        if( !empty($user) && !empty($user['id']) ) {
            return $user['id'];
        }
        return 0;
    }

    public static function isSale( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('sale', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isMedia( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('media', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isShiper( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('shiper', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isFinancial( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('financial', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isMediaLeader( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && $user['roles_type'] == 'mediaLeader' ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isMediaNormal( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && $user['roles_type'] == 'media' ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isSalesAdmin( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && $user['roles_type'] == 'salesAdmin' ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isStaff( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && $user['roles_type'] == 'staff' ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isManagement( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && $user['roles_type'] == 'management' ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function hasManagerClients( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('sale', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function hasPermissionEnumOrder( $user, $enum, $type )
    {
        if( !empty($user)  && !empty($enum) && !empty($type) ) {
            $roles_type = $user['roles_type'];
            $roleEnumScopeAction = User::$roleEnumScopeAction;
            if (    !empty($roleEnumScopeAction[$roles_type]) 
                    && !empty($roleEnumScopeAction[$roles_type][$enum]) 
                    && in_array($type, $roleEnumScopeAction[$roles_type][$enum]) ) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function inEnumBackList( $ei_ , $ej_ )
    {
        $roleEnumBackList = User::$roleEnumBackList;
        if( !empty($ei_)  && !empty($ej_)
            && !empty($roleEnumBackList[$ei_])
            && in_array($ej_, $roleEnumBackList[$ei_]) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getRoleEnumBackList( $type )
    {
        $roleEnumBackList = User::$roleEnumBackList;
        if( !empty($type)  && !empty($roleEnumBackList[$type]) ) {
            return $roleEnumBackList[$type];
        }
        return array();
    }

    public static function getChildId( $user )
    {
        if( !empty($user) && !empty($user['childrenID']) ) {
            return $user['childrenID'];
        }
        return array();
    }

    public static function getRolesTypes( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) ) {
            $roles_type = $user['roles_type'];
            if ( !is_array($roles_type) ) {
                $roles_type = explode(',',$roles_type);
            }
            $roles_type[] = 'public';
            return $roles_type;
        }
        return array();
    }

    public static function getRolesIds( $user )
    {
        if( !empty($user) && !empty($user['rolesIds']) ) {
            return $user['rolesIds'];
        }
        return array();
    }

    public static function getRolesId( $user )
    {
        if( !\HelperUser::isAdmin($user) && !empty($user) && !empty($user['roles_id']) ) {
            return $user['roles_id'];
        }
        return 0;
    }
    
    public static function isStock( $user )
    {
        if( !empty($user) && !empty($user['roles_type']) 
            && in_array('stock', Common::parseArray($user['roles_type'])) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function hasManagerStock( $user )
    {
        if ( User::isAdmin($user) ) {
            return TRUE;
        }
        
        if( !empty($user) 
            && !empty($user['permissions']) ) {
            return Permission::hasPermission($user, 'Backend', 'Store', 'add') && Permission::hasPermission($user, 'Backend', 'Store', 'edit');
        }
        return FALSE;
    }

    public static function hasSeePrice( $user )
    {
        if ( !\HelperUser::isAdmin($user) ){
            return FALSE;
        } 
        return TRUE;
    }

    public static function getId( $user )
    {
        if( !empty($user) && !empty($user['id']) ) {
            return $user['id'];
        }
        return 0;
    }

    public static function getEmail( $user )
    {
        if( !empty($user) && !empty($user['email']) ) {
            return $user['email'];
        }
        return '';
    }

    public static function getPhone( $user )
    {
        if( !empty($user) && !empty($user['phone']) ) {
            return $user['phone'];
        }
        return '';
    }

    public static function getAddress( $user )
    {
        if( !empty($user) && !empty($user['address']) ) {
            return $user['address'];
        }
        return '';
    }

    public static function getAvatar( $user )
    {
        if( !empty($user) && !empty($user['avatar']) ) {
            return $user['avatar'];
        }
        return '';
    }

    public static function getLabelId( $user )
    {
        if( !empty($user) && !empty($user['label_id']) ) {
            return $user['label_id'];
        }
        return 0;
    }

    public static function getLabelColor( $user )
    {
        if( !empty($user) && !empty($user['label_color']) ) {
            return $user['label_color'];
        }
        return '';
    }

    public static function getLabelDescription( $user )
    {
        if( !empty($user) && !empty($user['label_description']) ) {
            return $user['label_description'];
        }
        return '';
    }

    public static function getFirstName( $user )
    {
        if( !empty($user) && !empty($user['first_name']) ) {
            return $user['first_name'];
        }
        return '';
    }

    public static function getLastName( $user )
    {
        if( !empty($user) && !empty($user['last_name']) ) {
            return $user['last_name'];
        }
        return '';
    }

    public static function getFullName( $user )
    {
        return trim(User::getFirstName($user) . ' ' . User::getLastName($user));
    }

    public static function getCreatedAt( $user )
    {
        if( !empty($user) && !empty($user['created_at']) ) {
            return $user['created_at'];
        }
        return '';
    }

    public static function getCreatedFirstName( $user )
    {
        if( !empty($user) && !empty($user['created_first_name']) ) {
            return $user['created_first_name'];
        }
        return '';
    }

    public static function getCreatedLastName( $user )
    {
        if( !empty($user) && !empty($user['created_last_name']) ) {
            return $user['created_last_name'];
        }
        return '';
    }

    public static function getCreatedFullName( $user )
    {
        return trim(User::getCreatedFirstName($user) . ' ' . User::getCreatedLastName($user));
    }

    public static function getParentFirstName( $user )
    {
        if( !empty($user) && !empty($user['parent_first_name']) ) {
            return $user['parent_first_name'];
        }
        return '';
    }

    public static function getParentLastName( $user )
    {
        if( !empty($user) && !empty($user['parent_last_name']) ) {
            return $user['parent_last_name'];
        }
        return '';
    }

    public static function getParentFullName( $user )
    {
        return trim(User::getParentFirstName($user) . ' ' . User::getParentLastName($user));
    }

    public static function getIsPublished( $user )
    {
        if( !empty($user) && !empty($user['is_published']) ) {
            return $user['is_published'];
        }
        return 0;
    }

    public static function isPublished( $user )
    {
        if( !empty($user) && !empty($user['is_published']) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getIsAdmin( $user )
    {
        if( !empty($user) && !empty($user['is_admin']) ) {
            return $user['is_admin'];
        }
        return 0;
    }

    public static function isAdmin( $user )
    {
        if( !empty($user) && !empty($user['is_admin']) ) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getUrlEdit( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/edit/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }

    public static function getUrlWall( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/wall/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }

    public static function getUrlPassword( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/password/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }

    public static function getUrlDetele( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/delete/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }

    public static function getUrlUnpublish( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/unpublish/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }

    public static function getUrlPublish( $user )
    {
        if( !empty($user) ) {
            return '/admin/users/publish/'.User::getId($user);
        }
        return 'javascript:void(0);';
    }
}
