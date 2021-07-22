<?php

return [
        'menu' =>[
           'clients' => 'الزبائن',
        ],

        'clients'     => [
            'title'          => 'إضافة زبون جديد',
            'titlecard'          => 'معلومات عامة عن الزبون',
            'titlecard2'          => ' ',
            'titletb' => 'لائحة الزبائن',
            'printoutitle' => 'سحب الوثائق',
            'docname' => 'اسم الوثيقة',
            'printdate' => 'تاريخ سحب الوثيقة',
            'license_title' => 'لائحة رخص القيادة للزبون',
            'attach_title' => 'صفحة الوثائق المرفقة',
            'newclient' => 'زبون جديد',
            'clients_license_add' => 'إضافة رخصة قيادة',
            'clients_docs_add' => 'إضافة وثيقة جديدة',
            'upclient' => 'تعديل معلومات الزبون',
            'showclient' => 'عرض معلومات الزبون',
            'buttons'         => [
                'btnadd'                => 'أضافة زبون جديد',
                'btnaddcontact'                => 'لائحة عقود التأجير',

        ],
        'tables'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'             => 'اسم الزبون',
            'name_helper'      => '',
            'mobile'        => 'رقم الخليوي',
            'mobile_helper' => '',
            'region'        => 'اسم المنطقة',
            'region_helper' => '',
            'client_type'        => 'نوع الزبون',
            'client_type_helper' => '',
            'actions'        => 'الاجراءات',
            'contractactions'        => 'عقود الإيجار',

            'license_id'            => 'الرقم التسلسلي',
            'license_client'        => 'رقم الزبون',
            'license_driver'        => 'اسم السائق',
            'license_num'           => 'رقم الرخصة',
            'license_placeid'         => 'رقم مكان الاصدار',
            'license_place'         => 'مكان الاصدار',
            'license_date'          => 'تاريخ الاصدار',
            'license_actions'       => 'الاجراءات',

            'attach_id'            => 'الرقم التسلسلي',
            'docname'        => 'اسم الوثيقة',
            'files'        => 'الملف المرفق',
//            'license_num'           => 'رقم الرخصة',
//            'license_placeid'         => 'رقم مكان الاصدار',
//            'license_place'         => 'مكان الاصدار',
//            'license_date'          => 'تاريخ الاصدار',
//            'license_actions'       => 'الاجراءات',





        ],
        'titles'         => [
                'view'                => 'معلومات عن الزبون',
                'license'         => 'إضافة رخص القيادة',
                'docs'             => 'إضافة الوثائق',
                'edit'      => 'تعديل معلومات الزبون',
                'delete'        => 'إلغاء معلومات الزبون',
                'liedit'        => 'تعديل بيانات رخصة القيادة',
                'lidelete'        => 'حذف بيانات رخصة القيادة',
                'viewdoc'        => 'عرض الوثيقة',
                'addimg'        => 'إضافة وثيقة',
                'editdoc'        => 'تعديل الوثيقة',
                'deletedoc'        => 'حذف الوثيقة',

            ],
        'fields'         => [
            'cname'               => 'اسم الزبون الثلاثي',
            'moname'             => 'اسم الام',
            'cadr'        => 'العنوان الدائم',
            'creg'        => 'اسم المنطقة',
            'cctype'        => 'نوع الزبون',

            'sid'             => 'رقم السجل',
            'place'        => 'مكان الولادة',
            'birthdate'        => 'تاريخ الولادة',
            'natio'        => 'الجنسية',

            'passnum'             => 'رقم الجواز',
            'passplace'        => 'مكان الاصدار',
            'passdate'        => 'تاريخ الاصدار',
            'cmob'        => 'رقم الخليوي',
            'cmob1'        => 'رقم الخليوي الدولي',
            'cland'        => 'رقم الهاتف الارضي',
        ],

        'modals' =>[
           'lbl_license_cname' => 'اسم الزبون',
           'lbl_doc_cname' => 'اسم الوثيقة',
           'lbl_license_driver' => 'اسم السائق',
           'lbl_license_linum' => 'رقم الرخصة',
           'lbl_license_place' => 'مكان الاصدار',
           'lbl_license_date' => 'تاريخ الاصدار',
           'lbl_license_save' => 'حفظ الببيانات',
           'lbl_license_exit' => 'خروج',
           'lbl_license_deleteconfirmation' => 'هل تريد فعلا حذف رخصة : ',
           'lbl_license_deletedocconfirmation' => 'هل تريد فعلا حذف هذه الوثيقة : ',
           'lbl_license_deleteconfirmationclient' => 'هل تريد فعلا حذف هذا الزبون : ',
           'lbl_license_questionmark' => ' ؟ ',
        ],
    ],
];
