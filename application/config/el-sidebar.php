<?php
/************ BACKEND ************/
$config['menu'] = array(
    'dashboard' => array(
        'role' => MANAGER . '|' . ADMINISTRATOR,
        'title' => 'Dashboard',
        'menu' => array(
            array(
                'class' => 'nav-top-item no-submenu dashboard',
                'link' => 'dashboard',
                'title' => 'Dashboard'
            )
        )
    ),
    'storage' => array(
        'role' => MANAGER . '|' . ADMINISTRATOR,
        'title' => 'Quản lý kho',
        'menu' => array(
            array(
                'class' => 'storage-add storage-edit',
                'link' => 'storage/edit',
                'title' => 'Thêm kho mới'
            ),
            array(
                'class' => 'storage-lists',
                'link' => 'storage/lists',
                'title' => 'Danh sách tên kho'
            )
        )
    ),
    'storage-question' => array(
        'role' => MANAGER . '|' . ADMINISTRATOR,
        'title' => 'Quản lý kho câu hỏi',
        'menu' => array(
            array(
                'class' => 'storage-question-add storage-question-edit',
                'link' => 'storage-question/edit',
                'title' => 'Thêm câu hỏi mới'
            ),
            array(
                'class' => 'storage-question-lists',
                'link' => 'storage-question/lists',
                'title' => 'Danh sách kho câu hỏi'
            )
        )
    ),
    'topic' => array(
        'role' => MANAGER . '|' . ADMINISTRATOR,
        'title' => 'Quản lý đề thi',
        'menu' => array(
            array(
                'class' => 'topic-create',
                'link' => 'topic/create',
                'title' => 'Tạo đề thi'
            ),
            array(
                'class' => 'topic-lists',
                'link' => 'topic/lists',
                'title' => 'Danh sách đề thi'
            ),
            array(
                'class' => 'topic-list_trash',
                'link' => 'topic/list_trash',
                'title' => 'Danh sách đề thi(trash)
								'
            )
        )
    ),
    'exam' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý hình thức thi',
        'menu' => array(
            array(
                'class' => 'exam-add exam-edit',
                'link' => 'exam/edit',
                'title' => 'Thêm hình thức thi'
            ),
            array(
                'class' => 'exam-lists',
                'link' => 'exam/lists',
                'title' => 'Danh sách hình thức thi'
            )
        )
    ),
    'academic' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý niên khóa',
        'menu' => array(
            array(
                'class' => 'academic-add academic-edit',
                'link' => 'academic/edit',
                'title' => 'Thêm niên khóa'
            ),
            array(
                'class' => 'academic-lists',
                'link' => 'academic/lists',
                'title' => 'Danh sách niên khóa'
            )
        )
    ),
    'block' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý khối',
        'menu' => array(
            array(
                'class' => 'block-add block-edit',
                'link' => 'block/edit',
                'title' => 'Thêm khối'
            ),
            array(
                'class' => 'block-lists',
                'link' => 'block/lists',
                'title' => 'Danh sách khối'
            )
        )
    ),
    'lop' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý lớp',
        'menu' => array(
            array(
                'class' => 'lop-add lop-edit',
                'link' => 'lop/edit',
                'title' => 'Thêm lớp'
            ),
            array(
                'class' => 'lop-lists',
                'link' => 'lop/lists',
                'title' => 'Danh sách lớp'
            )
        )
    ),
    'subject' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý môn học',
        'menu' => array(
            array(
                'class' => 'subject-add subject-edit',
                'link' => 'subject/edit',
                'title' => 'Thêm môn học'
            ),
            array(
                'class' => 'subject-lists',
                'link' => 'subject/lists',
                'title' => 'Danh sách môn học'
            )
        )
    ),
    'students' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý học sinh',
        'menu' => array(
            array(
                'class' => 'students-add students-edit',
                'link' => 'students/edit',
                'title' => 'Thêm học sinh'
            ),
            array(
                'class' => 'students-lists',
                'link' => 'students/lists',
                'title' => 'Danh sách học sinh'
            )
        )
    ),
    'users' => array(
        'role' => ADMINISTRATOR,
        'title' => 'Quản lý users',
        'menu' => array(
            array(
                'class' => 'users-add users-edit',
                'link' => 'users/edit',
                'title' => 'Thêm users'
            ),
            array(
                'class' => 'users-lists',
                'link' => 'users/lists',
                'title' => 'Danh sách users'
            )
        )
    )
);