<?php

return [
        'menu' =>[
           'cars' => 'السيارات',
        ],

        'cars'     => [
            'title'          => 'السيارات',
            'titlecard'          => 'معلومات عامة عن السيارة',
            'titleattach'          => 'ملفات السيارة',
            'titlecard2'          => ' ',
            'titletb' => 'لائحة السيارات',
            'filepreview' => 'عرض الملف',
            'closemodal' => 'إغلاق',
            'titletbimages' => 'لائحة الملفات المرفقة',
            'carscount' => 'عدد السيارات الموجودة',
            'carsin' => 'عرض السيارات المتاحة للإيجار',
            'carsout' => 'عرض السيارات المؤجرة',
            'noresult' => 'عذراً لا يوجد أي نتيجة لبحثك في قاعدة البيانات',
            'carsall' => 'عرض كل السيارات',
            'searchbar' => 'إبحث عن سيارة محددة',
            'titletbadminpanel' => 'لائحة السيارات المتاحة للأجار',
            'license_title' => 'لائحة رخص القيادة للزبون',
            'attach_title' => 'صفحة الوثائق المرفقة',
            'newcar' => 'إضافة سيارة جديدة',
            'clients_license_add' => 'إضافة رخصة قيادة',
            'clients_docs_add' => 'إضافة وثيقة جديدة',
            'upcar' => 'تعديل معلومات السيارة',
            'showcar' => 'عرض معلومات السيارة',
            'buttons'         => [
                'btnadd'                => 'أضافة سيارة جديدة',

        ],
        'tables'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'carname'             => 'اسم السيارة',
            'platnumber'             => 'رقم اللوحة',
            'type'             => 'الماركة',
            'model'             => 'الموديل',
            'color'             => 'اللون',
            'rates'             => 'السعر',
            'photo'             => 'الصورة',
            'name_helper'      => '',
            'mobile'        => 'رقم الخليوي',
            'mobile_helper' => '',
            'region'        => 'اسم المنطقة',
            'region_helper' => '',
            'actions'        => 'الاجراءات',

            'filetype'        => 'نوع الملف المرفق',
            'filename'        => 'اسم الملف المرفق',
            'attchactions'        => 'الإجراءات',
            'attachimages'        => 'الصور المرفقة',
            'attachdocs'        => 'الوثائق المرفقة',
            'noresult'        => 'لا يوجد أي بيانات لعرضها في الجدول',

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
        'fields'         => [
            'carname'               => 'إسم السيارة',
            'platnumber'             => 'رقم لوحة السيارة',
            'cartype'        => 'ماركة السيارة',
            'carmodel'        => 'موديل السيارة',
            'carcolor'        => 'لون السيارة',

            'chanum'             => 'رقم هيكل السيارة',
            'engnum'        => 'رقم محرك السيارة',
            'specs'        => 'خصائص السيارة',
            'carrate'        => 'القيمة التأجيرية للسيارة',
            'curr'        => 'العملة',
            'branch'        => 'اسم الفرع',
            'carengine'        => 'نوع المحرك',

            'carspecs'             => 'مواصفات السيارة',
            'carused'        => 'متى وضعت هذه السيارة في الخدمة',
            'carstop'        => 'إيقاف السيارة عن العمل',
            'carimage'        => 'صورة السيارة',
            'stopdate'        => 'تاريخ إيقاف السيارة عن العمل',
            'photo'        => 'صورة السيارة',
            'passenger'        => 'عدد الركاب',
            'bags'        => 'عدد الحقائب',
            'doors'        => 'عدد الابواب',
            'transmission'        => 'نوع ناقل الحركة',
        ],

        'modals' =>[
           'lbl_license_cname' => 'اسم الزبون',
           'lbl_license_driver' => 'اسم السائق',
           'lbl_license_linum' => 'رقم الرخصة',
           'lbl_license_place' => 'مكان الاصدار',
           'lbl_license_date' => 'تاريخ الاصدار',
           'lbl_license_save' => 'حفظ الببيانات',
           'lbl_license_exit' => 'خروج',
           'lbl_license_deleteconfirmation' => 'هل تريد فعلا حذف رخصة : ',
           'lbl_license_deleteconfirmationclient' => 'هل تريد فعلا حذف هذا الزبون : ',
           'lbl_license_questionmark' => ' ؟ ',
        ],

            'titles' =>[
                'addpic' => 'إضافة وثائق للسيارة',
                'actions' => 'إضافة وثائق السيارة',
                'edit' => 'تعديل بيانات السيارة',
                'delete' => 'حذف بيانات السيارة',
            ],
    ],
];
