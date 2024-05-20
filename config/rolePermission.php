<?php

return [
    'default_permissions' =>  [
        "login",
        "profile",
        "update_profile",
        "logout"
    ],
    'role_remove' => [
        "role.get_list",
        "role.change_permission",
        "session.upsert",
        "login",
        "logout",
        "user.register_face",
        "user.register_face_status",
        "user.getall",
        "role.listRole",
        "model.upsert"
    ],
];
