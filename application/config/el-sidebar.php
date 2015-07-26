<?php
/************ BACKEND ************/
$config['menu'] = array(
    'dashboard' => array(
        'role' => [
            MANAGER,
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-home',
        'title' => 'Dashboard',
        'link' => BACKEND_V2_TMPL_PATH . 'dashboard',
        'class' => 'dashboard',
        'child' => []
    ),
    'storage' => array(
        'role' => [
            MANAGER,
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-copy',
        'title' => 'Quản lý kho',
        'child' => array(
            array(
                'class' => 'storage-add storage-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'storage/edit',
                'title' => 'Thêm kho mới'
            ),
            array(
                'class' => 'storage-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'storage/lists',
                'title' => 'Danh sách tên kho'
            )
        )
    ),
    'storage-question' => array(
        'role' => [
            MANAGER,
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-tasks',
        'title' => 'Quản lý kho câu hỏi',
        'child' => array(
            array(
                'class' => 'storage-question-add storage-question-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'storage-question/edit',
                'title' => 'Thêm câu hỏi mới'
            ),
            array(
                'class' => 'storage-question-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'storage-question/lists',
                'title' => 'Danh sách kho câu hỏi'
            )
        )
    ),
    'topic' => array(
        'role' => [
            MANAGER,
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-list-alt',
        'title' => 'Quản lý đề thi',
        'child' => array(
            array(
                'class' => 'topic-create',
                'link' => BACKEND_V2_TMPL_PATH . 'topic/create',
                'title' => 'Tạo đề thi'
            ),
            array(
                'class' => 'topic-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'topic/lists',
                'title' => 'Danh sách đề thi'
            ),
            array(
                'class' => 'topic-list_trash',
                'link' => BACKEND_V2_TMPL_PATH . 'topic/list_trash',
                'title' => 'Danh sách đề thi(trash)
								'
            )
        )
    ),
    'exam' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-table',
        'title' => 'Quản lý hình thức thi',
        'child' => array(
            array(
                'class' => 'exam-add exam-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'exam/edit',
                'title' => 'Thêm hình thức thi'
            ),
            array(
                'class' => 'exam-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'exam/lists',
                'title' => 'Danh sách hình thức thi'
            )
        )
    ),
    'academic' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-map-marker',
        'title' => 'Quản lý niên khóa',
        'child' => array(
            array(
                'class' => 'academic-add academic-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'academic/edit',
                'title' => 'Thêm niên khóa'
            ),
            array(
                'class' => 'academic-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'academic/lists',
                'title' => 'Danh sách niên khóa'
            )
        )
    ),
    'block' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-columns',
        'title' => 'Quản lý khối',
        'child' => array(
            array(
                'class' => 'block-add block-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'block/edit',
                'title' => 'Thêm khối'
            ),
            array(
                'class' => 'block-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'block/lists',
                'title' => 'Danh sách khối'
            )
        )
    ),
    'clazz' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-align-left',
        'title' => 'Quản lý lớp',
        'child' => array(
            array(
                'class' => 'clazz-add clazz-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'clazz/edit',
                'title' => 'Thêm lớp'
            ),
            array(
                'class' => 'clazz-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'clazz/lists',
                'title' => 'Danh sách lớp'
            )
        )
    ),
    'subject' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-align-left',
        'title' => 'Quản lý môn học',
        'child' => array(
            array(
                'class' => 'subject-add subject-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'subject/edit',
                'title' => 'Thêm môn học'
            ),
            array(
                'class' => 'subject-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'subject/lists',
                'title' => 'Danh sách môn học'
            )
        )
    ),
    'students' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-align-left',
        'title' => 'Quản lý học sinh',
        'child' => array(
            array(
                'class' => 'students-add students-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'students/edit',
                'title' => 'Thêm học sinh'
            ),
            array(
                'class' => 'students-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'students/lists',
                'title' => 'Danh sách học sinh'
            )
        )
    ),
    'users' => array(
        'role' => [
            ADMINISTRATOR
        ],
        'icon' => 'fa fa-user',
        'title' => 'Quản lý users',
        'child' => array(
            array(
                'class' => 'users-add users-edit',
                'link' => BACKEND_V2_TMPL_PATH . 'users/edit',
                'title' => 'Thêm users'
            ),
            array(
                'class' => 'users-lists',
                'link' => BACKEND_V2_TMPL_PATH . 'users/lists',
                'title' => 'Danh sách users'
            )
        )
    )
);