<?php

/**
 * ar
 *
 * US English message token translations
 *
 * @package UserFrosting
 * @link http://www.userfrosting.com/components/#i18n
 * @author Alexander Weissman
 */

/*
{{name}} - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();

// Site Content
$lang = array_merge($lang, [
    "REGISTER_WELCOME" => "التسجيل سريع وبسيط.",
    "MENU_USERS" => "المستخدمون",
    "MENU_CONFIGURATION" => "الإعدادات",
    "MENU_SITE_SETTINGS" => "إعدادات الموقع",
    "MENU_GROUPS" => "المجموعات",
    "MENU_PERMISSIONS" => "الأذونات",
    "EMAIL_MGMT" => "إدارة البريد الإلكتروني",
    "SMTP_MAIL_CONFIG" => "SMTP  إعدادات البريد الإلكتروني",
    "MYSQL_CONFIG" => "MYSQL إعدادات",
    "MSSQL_CONFIG" => "MSSQL إعدادات",
    "NEIGHBORHOOD" => "الأحياء",
    "DISCOUNT" => "الخصومات",
    "HEADER_MESSAGE_ROOT" => "لقد تم تسجيل دخولك باعتبارك مستخدم الجذر"
]);

// Installer
$lang = array_merge($lang,array(
    "INSTALLER_INCOMPLETE" => "لا يمكنك تسجيل حساب الجذر حتى يتم إكمال المثبت بنجاح!",
    "MASTER_ACCOUNT_EXISTS" => "الحساب الرئيسي موجود بالفعل!",
    "MASTER_ACCOUNT_NOT_EXISTS" => "لا يمكنك تسجيل حساب حتى يتم إنشاء الحساب الرئيسي!",
    "CONFIG_TOKEN_MISMATCH" => "عذرا ، الرمز هذا غير صحيح."
));

// Account
$lang = array_merge($lang,array(
    "ACCOUNT_SPECIFY_USERNAME" => "الرجاء إدخال اسم المستخدم.",
    "ACCOUNT_SPECIFY_DISPLAY_NAME" => "الرجاء إدخال اسم العرض الخاص بك.",
    "ACCOUNT_SPECIFY_PASSWORD" => "من فضلك أدخل رقمك السري.",
    "ACCOUNT_SPECIFY_EMAIL" => "الرجاء إدخال عنوان البريد الإلكتروني الخاص بك.",
    "ACCOUNT_SPECIFY_CAPTCHA" => "الرجاء إدخال كود التحقق.",
    "ACCOUNT_SPECIFY_LOCALE" => "الرجاء تحديد موقع صالح.",
    "ACCOUNT_INVALID_EMAIL" => "عنوان البريد الإلكتروني غير صالح",
    "ACCOUNT_INVALID_USERNAME" => "اسم مستخدم غير صحيح",
    "ACCOUNT_INVALID_USER_ID" => "معرف المستخدم المطلوب غير موجود.",
    "ACCOUNT_USER_OR_EMAIL_INVALID" => "اسم المستخدم أو عنوان البريد الإلكتروني غير صالح.",
    "ACCOUNT_USER_OR_PASS_INVALID" => "اسم المستخدم او كلمة المرور غير صحيحة.",
    "ACCOUNT_ALREADY_ACTIVE" => "يتم تنشيط حسابك بالفعل.",
    "ACCOUNT_REGISTRATION_DISABLED" => "نأسف ، تم تعطيل تسجيل الحساب.",
    "ACCOUNT_REGISTRATION_BROKEN" => "نأسف لوجود مشكلة في عملية تسجيل الحساب. يرجى الاتصال بنا مباشرة للحصول على المساعدة.",
    "ACCOUNT_REGISTRATION_LOGOUT" => "أنا آسف ، لا يمكنك التسجيل للحصول على حساب أثناء تسجيل الدخول. الرجاء تسجيل الخروج أولاً.",
    "ACCOUNT_INACTIVE" => "حسابك غير نشط. تحقق من مجلد رسائل البريد الإلكتروني / البريد العشوائي للحصول على تعليمات تنشيط الحساب.",
    "ACCOUNT_INVALID" => "هذا الحساب غير موجود. قد تم حذفه. يرجى الاتصال بنا للحصول على مزيد من المعلومات.",
    "ACCOUNT_DISABLED" => "تم تعطيل هذا الحساب. يرجى الاتصال بنا للحصول على مزيد من المعلومات.",
    "ACCOUNT_USER_CHAR_LIMIT" => "يجب أن يكون اسم المستخدم الخاص بك بين {{min}} و {{max}} حرفا.",
    "ACCOUNT_USER_INVALID_CHARACTERS" => "يمكن أن يتضمن اسم المستخدم أحرفًا أبجدية رقمية فقط",
    "ACCOUNT_USER_NO_LEAD_WS" => "لا يمكن أن يبدأ اسم المستخدم بمسافة",
    "ACCOUNT_USER_NO_TRAIL_WS" => "لا يمكن أن ينتهي اسم المستخدم بمسافة بيضاء",
    "ACCOUNT_DISPLAY_CHAR_LIMIT" => "يجب أن يكون اسم العرض الخاص بك بين {{min}} و {{max}} حرفا.",
    "ACCOUNT_PASS_CHAR_LIMIT" => "يجب أن تكون كلمة المرور الخاصة بك بين {{min}} و {{max}} حرفا.",
    "ACCOUNT_EMAIL_CHAR_LIMIT" => "يجب أن يكون البريد الإلكتروني بين {{min}} و {{max}} حرفا.",
    "ACCOUNT_TITLE_CHAR_LIMIT" => "يجب أن تكون العناوين بين {{min}} و {{max}} حرفا.",
    "ACCOUNT_PASS_MISMATCH" => "يجب أن تتطابق كلمة المرور مع تأكيد كلمة المرور",
    "ACCOUNT_DISPLAY_INVALID_CHARACTERS" => "يمكن أن يتضمن اسم العرض أحرفًا أبجدية رقمية فقط",
    "ACCOUNT_USERNAME_IN_USE" => "اسم المستخدم '{{user_name}}' قيد الاستخدام بالفعل",
    "ACCOUNT_DISPLAYNAME_IN_USE" => "اسم العرض '{{display_name}}' قيد الاستخدام بالفعل",
    "ACCOUNT_EMAIL_IN_USE" => "البريد الإلكتروني '{{email}}' قيد الاستخدام بالفعل",
    "ACCOUNT_LINK_ALREADY_SENT" => "تم بالفعل إرسال بريد إلكتروني للتفعيل إلى عنوان البريد الإلكتروني هذا في الماضي {{resend_activation_threshold}} ثانيا. الرجاء معاودة المحاولة في وقت لاحق.",
    "ACCOUNT_NEW_ACTIVATION_SENT" => "لقد أرسلنا لك رابط تفعيل جديد عبر البريد الإلكتروني ، يرجى التحقق من بريدك الإلكتروني",
    "ACCOUNT_SPECIFY_NEW_PASSWORD" => "الرجاء إدخال كلمة المرور الجديدة الخاصة بك",
    "ACCOUNT_SPECIFY_CONFIRM_PASSWORD" => "يرجى تأكيد كلمة المرور الجديدة الخاصة بك",
    "ACCOUNT_NEW_PASSWORD_LENGTH" => "يجب أن تكون كلمة المرور الجديدة بين {{min}} و {{max}} حرفا",
    "ACCOUNT_PASSWORD_INVALID" => "كلمة المرور الحالية لا تتطابق مع كلمة المرور المسجلة لدينا",
    "ACCOUNT_DETAILS_UPDATED" => "تم تحديث تفاصيل الحساب للمستخدم '{{user_name}}'",
    "ACCOUNT_CREATION_COMPLETE" => "حساب للمستخدم الجديد '{{user_name}}' تم إنشاء.",
    "ACCOUNT_ACTIVATION_COMPLETE" => "لقد قمت بتنشيط حسابك بنجاح. يمكنك الآن تسجيل الدخول.",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE1" => "لقد قمت بالتسجيل بنجاح. يمكنك الآن تسجيل الدخول.",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE2" => "لقد قمت بالتسجيل بنجاح. ستتلقى قريبًا بريدًا إلكترونيًا للتفعيل. يجب عليك تفعيل حسابك قبل تسجيل الدخول.",
    "ACCOUNT_PASSWORD_NOTHING_TO_UPDATE" => "لا يمكنك التحديث بنفس كلمة المرور",
    "ACCOUNT_PASSWORD_CONFIRM_CURRENT" => "يرجى تأكيد كلمة السر الحالية",
    "ACCOUNT_SETTINGS_UPDATED" => "تم تحديث إعدادات الحساب",
    "ACCOUNT_PASSWORD_UPDATED" => "تم تحديث الرقم السري الحساب",
    "ACCOUNT_EMAIL_UPDATED" => "تم تحديث البريد الإلكتروني للحساب",
    "ACCOUNT_TOKEN_NOT_FOUND" => "الرمز غير موجود / الحساب نشط بالفعل",
    "ACCOUNT_DELETE_MASTER" => "لا يمكنك حذف الحساب الرئيسي!",
    "ACCOUNT_DISABLE_MASTER" => "لا يمكنك تعطيل الحساب الرئيسي!",
    "ACCOUNT_DISABLE_SUCCESSFUL" => "حساب للمستخدم'{{user_name}}' تم تعطيله بنجاح.",
    "ACCOUNT_ENABLE_SUCCESSFUL" => "حساب للمستخدم '{{user_name}}' تم تمكينه بنجاح.",
    "ACCOUNT_DELETION_SUCCESSFUL" => "المستخدم '{{user_name}}' تم حذفه بنجاح.",
    "ACCOUNT_MANUALLY_ACTIVATED" => "{{user_name}} تم تنشيط الحساب يدويًا",
    "ACCOUNT_DISPLAYNAME_UPDATED" => "{{user_name}} تم تغيير اسم العرض إلى '{{display_name}}'",
    "ACCOUNT_TITLE_UPDATED" => "{{user_name}} تغير العنوان إلى '{{title}}'",
    "ACCOUNT_GROUP_ADDED" => "تمت إضافة المستخدم إلى المجموعة '{{name}}'.",
    "ACCOUNT_GROUP_REMOVED" => "تمت إزالة المستخدم من المجموعة '{{name}}'.",
    "ACCOUNT_GROUP_NOT_MEMBER" => "المستخدم ليس عضوا في المجموعة '{{name}}'.",
    "ACCOUNT_GROUP_ALREADY_MEMBER" => "المستخدم عضو بالفعل في المجموعة '{{name}}'.",
    "ACCOUNT_PRIMARY_GROUP_SET" => "تم تعيين المجموعة الأساسية لـ '{{user_name}}'.",
    "ACCOUNT_WELCOME" => "مرحبا بعودتك, {{display_name}}"
));

// Generic validation
$lang = array_merge($lang, array(
    "VALIDATE_REQUIRED" => "الحقل '{{self}}' يجب تحديدها.",
    "VALIDATE_BOOLEAN" => "قيمة '{{self}}' يجب أن يكون إما \"0\" أو \"1\".",
    "VALIDATE_INTEGER" => "قيمة '{{self}}' يجب أن يكون صحيحا.",
    "VALIDATE_ARRAY" => "قيمة '{{self}}' يجب أن يكون في مصفوفة.",
    "VALIDATE_NO_LEAD_WS" => "قيمة '{{self}}' لا يمكن أن يبدأ بمسافات أو علامات تبويب أو مسافات بيضاء أخرى",
    "VALIDATE_NO_TRAIL_WS" => "قيمة '{{self}}' لا يمكن أن ينتهي بمسافات أو علامات تبويب أو مسافات بيضاء أخرى"
));

// Configuration
$lang = array_merge($lang,array(
    "CONFIG_PLUGIN_INVALID" => "أنت تحاول تحديث إعدادات المكون الإضافي '{{plugin}}', ولكن لا يوجد مكون إضافي بهذا الاسم.",
    "CONFIG_SETTING_INVALID" => "أنت تحاول تحديث الإعداد '{{name}}' للمكوِّن الإضافي '{{plugin}}', لكنها غير موجودة.",
    "CONFIG_NAME_CHAR_LIMIT" => "يجب أن يكون اسم الموقع بين {{min}} و {{max}} حرفا",
    "CONFIG_URL_CHAR_LIMIT" => "يجب أن يكون عنوان url للموقع بين {{min}} و {{max}} حرفا",
    "CONFIG_EMAIL_CHAR_LIMIT" => "يجب أن يكون البريد الإلكتروني للموقع بين {{min}} و {{max}} حرفا",
    "CONFIG_TITLE_CHAR_LIMIT" => "يجب أن يكون عنوان المستخدم الجديد بين {{min}} و {{max}} حرفا",
    "CONFIG_ACTIVATION_TRUE_FALSE" => "يجب أن يكون تنشيط البريد الإلكتروني إما \"صواب\" أو \"خطأ\"",
    "CONFIG_REGISTRATION_TRUE_FALSE" => "يجب أن يكون تسجيل المستخدم إما \"صحيح\" أو \"خطأ\"",
    "CONFIG_ACTIVATION_RESEND_RANGE" => "يجب أن يكون حد التنشيط بين {{min}} و {{max}} ساعات",
    "CONFIG_EMAIL_INVALID" => "البريد الإلكتروني الذي أدخلته غير صالح",
    "CONFIG_UPDATE_SUCCESSFUL" => "تم تحديث تكوين موقعك. قد تحتاج إلى تحميل صفحة جديدة حتى تصبح جميع الإعدادات سارية المفعول",
    "MINIFICATION_SUCCESS" => "تم تصغير وتسلسل CSS و JS بنجاح لجميع مجموعات الصفحات."
));

// Forgot Password
$lang = array_merge($lang,array(
    "FORGOTPASS_INVALID_TOKEN" => "الرمز السري الخاص بك غير صالح",
    "FORGOTPASS_OLD_TOKEN" => "وقت انتهاء صلاحية الرمز المميز",
    "FORGOTPASS_COULD_NOT_UPDATE" => "تعذر تحديث كلمة المرور",
    "FORGOTPASS_REQUEST_CANNED" => "تم إلغاء طلب كلمة المرور المفقودة",
    "FORGOTPASS_REQUEST_EXISTS" => "يوجد بالفعل طلب معلق لكلمة مرور مفقودة على هذا الحساب",
    "FORGOTPASS_REQUEST_SENT" => "تم إرسال رابط إعادة تعيين كلمة المرور عبر البريد الإلكتروني إلى العنوان المسجل للمستخدم '{{user_name}}'",
    "FORGOTPASS_REQUEST_SUCCESS" => "لقد أرسلنا إليك عبر البريد الإلكتروني تعليمات حول كيفية استعادة الوصول إلى حسابك"
));

// Mail
$lang = array_merge($lang,array(
    "MAIL_ERROR" => "خطأ فادح عند محاولة البريد ، اتصل بمسؤول الخادم",
));

// Miscellaneous
$lang = array_merge($lang,array(
    "PASSWORD_HASH_FAILED" => "فشل تجزئة كلمة المرور. يرجى الاتصال بمسؤول الموقع.",
    "NO_DATA" => "لا توجد بيانات / إرسال بيانات سيئة",
    "CAPTCHA_FAIL" => "فشل سؤال الأمان",
    "CONFIRM" => "تأكيد",
    "DENY" => "رفض",
    "SUCCESS" => "نجاح",
    "ERROR" => "خطأ",
    "SERVER_ERROR" => "عفوًا ، يبدو أن خادمنا ربما يكون قد أخطأ. إذا كنت مسؤولاً ، فالرجاء التحقق من سجلات أخطاء PHP.",
    "NOTHING_TO_UPDATE" => "لا شيء لتحديث",
    "SQL_ERROR" => "خطأ SQL فادح",
    "FEATURE_DISABLED" => "هذه الميزة معطلة حاليا",
    "ACCESS_DENIED" => "حسنًا ، يبدو أنه ليس لديك إذن للقيام بذلك.",
    "LOGIN_REQUIRED" => "عذرا ، يجب عليك تسجيل الدخول للوصول إلى هذا المورد.",
    "LOGIN_ALREADY_COMPLETE" => "انت بالفعل داخل!"
));

// Permissions
$lang = array_merge($lang,array(
    "GROUP_INVALID_ID" => "معرف المجموعة المطلوب غير موجود",
    "GROUP_NAME_CHAR_LIMIT" => "يجب أن تكون أسماء المجموعات بين {{min}} و {{max}} حرفا",
    "AUTH_HOOK_CHAR_LIMIT" => "يجب أن تكون أسماء ربط التخويل بين {{min}} و {{max}} حرفا",
    "GROUP_NAME_IN_USE" => "اسم المجموعة '{{name}}' قيد الاستخدام بالفعل",
    "GROUP_DELETION_SUCCESSFUL" => "تم حذف المجموعة بنجاح '{{name}}'",
    "GROUP_CREATION_SUCCESSFUL" => "تم إنشاء المجموعة بنجاح '{{name}}'",
    "GROUP_UPDATE" => "تفاصيل عن المجموعة '{{name}}' تم التحديث بنجاح.",
    "CANNOT_DELETE_GROUP" => "المجموعة '{{name}}' لا يمكن حذفها",
    "GROUP_CANNOT_DELETE_DEFAULT_PRIMARY" => "المجموعة '{{name}}' لا يمكن حذفه لأنه تم تعيينه كمجموعة أساسية افتراضية للمستخدمين الجدد. يرجى أولاً تحديد مجموعة أساسية افتراضية مختلفة.",
    "GROUP_AUTH_EXISTS" => "المجموعة '{{name}}' لديها بالفعل قاعدة محددة للربط '{{hook}}'.",
    "GROUP_AUTH_CREATION_SUCCESSFUL" => "حكم عن '{{hook}}' تم إنشاؤه بنجاح للمجموعة '{{name}}'.",
    "GROUP_AUTH_UPDATE_SUCCESSFUL" => "قاعدة منح حق الوصول إلى المجموعة '{{name}}' إلى '{{hook}}' تم تحديثه بنجاح.",
    "GROUP_AUTH_DELETION_SUCCESSFUL" => "قاعدة منح حق الوصول إلى المجموعة '{{name}}' إلى '{{hook}}' تم حذفه بنجاح.",
    "GROUP_DEFAULT_PRIMARY_NOT_DEFINED" => "لا يمكنك إنشاء مستخدم جديد لأنه لم يتم تحديد مجموعة أساسية افتراضية. يرجى التحقق من إعدادات مجموعتك."
));

// dashboard
$lang = array_merge($lang, array(
    "registered" => "المسجلين",
    "view_details" => "عرض التفاصيل",
    "units" => "الشقق السكنية",
    "all" => "الجميع",
    "neighborhood" => "الحي",
    "view_more_details" => "عرض تفاصيل أكثر",
    "recent_not_signed_reservations" => "الحجوزات الأخيرة غير الموقعة",
    "company_code" => "رمز الشقة",
    "building_type" => "رمز البناية",
    "customer_name" => "إسم الزبون",
    "reservation_date" => "تاريخ الحجز",
    "payment_date" => "تاريخ الدفع",
    "payment_amount" => "قيمة الدفعة",
    "payment_number" => "رقم الدفعة",
    "from" => "من",
    "to" => "إلى",
    "upcomming_payments" => "الدفعات القادمة",
    "last_modified_user" => "آخر مستخدم تم التعديل",
));

// index page
$lang = array_merge($lang, array(
    "delete_image" => "حذف الصورة",
    "parking" => "الموقف",
    "storage" => "المخزن",
    "select_item" => "إختر عنصراً",
    "select_parking" => "إختر موقف",
    "select_storage" => "إختر مخزن",
    "description" => "الوصف",
    "floor" => "الطابق",
    "parking_number" => "رقم الموقف",
    "price" => "السعر",
    "tabu_number" => "رقم الطابو",
    "area" => "المساحة",
    "storage_number" => "رقم المخزن",
    "reserve" => "حجز",
    "tabu_code" => "رمز الطابو",
));

// create reservation
$lang = array_merge($lang, array(
    "customer_info" => "معلومات الزبون",
    "leadID" => "Lead ID",
    "customer_name" => "إسم الزبون",
    "place_of_issue" => "مكان الإصدار",
    "address" => "العنوان",
    "id_number" => "رقم الهوية",
    "city" => "المدينة",
    "region" => "المنطقة",
    "street" => "الشارع",
    "mail_box" => "صندوق بريد",
    "postal_code" => "الرمز البريدي",
    "email" => "البريد الإلكتروني",
    "work_phone" => "رقم العمل",
    "telephone_number" => "رقم الهاتف",
    "phone_number" => "رقم الهاتف المحمود",
    "collected_fees" => "رسوم التسجيل",
    "select_collected_fees" => "إختر رسوم التسجيل",
    "reservation_date" => "تاريخ الحجز",
    "reservation_user" => "مسؤول الحجز",
    "payment_method" => "طريقة الدفع",
    "select_payment_method" => "إختر طريقة الدفع",
    "rent_to_buy" => "الإيجار حتى الشراء",
    "cash" => "دفع فوري",
    "finance" => "Finance",
    "direct_installment" => "التقسيط المباشر",
    "added_value" => "القيمة المضافة",
    "price_details" => "تفاصيل السعر",
    "select" => "إختر",
    "addition" => "الإضافات",
    "discount" => "الخصومات",
    "no_addition" => "لا يوجد إضافة",
    "no_discount" => "لا يوجد خصم",
    "clarification" => "التوضيح",
    "discount_password" => "الرقم السري للخصم",
    "user_password" => "الرقم السري للمستخدم",
    "unit_total_price" => "السهر الإجمالي للشقة",
    "price_without_discount" => "السعر من غير الخصم",
    "notes" => "ملاحظات",
    "next" => "التالي",
    "cancel" => "إلغاء",
    "previous" => "السابق",
    "save_temporary" => "حفظ مؤقت",
    "identification_type" => "نوع الهوية",
));

// cancel reservation
$lang = array_merge($lang, array(
    "are_you_sure" => "هل أنت متأكد",
    "go_back" => "الرجوع",
    "continue" => "التالي",
    "cancellation_modal_message" => [
        "unit" => "سيؤدي هذا إلى إلغاء الحجز للوحدة",
        "building" => "في البناية",
        "company_code" => "مع رمز الشقة",
        "tabu_code" => "و رمز الطابو",
        "at" => "عند",
    ]
));

// unit delete
$lang = array_merge($lang, array(
    "confirmation" => "التأكيد",
    "delete_unit_message" => "هل أنت متأكد أنك تريد حذف هذه الشقة بالكامل من جدول الشقق؟",
    "confirm" => "تأكيد",

));

// contract delete
$lang = array_merge($lang, array(
    "delete_contract_message" => "هل أنت متأكد من أنك تريد حذف هذه الشقة بالكامل مع معلومات الحجز والعقد؟",
));

// check reservation
$lang = array_merge($lang, array(
    "check_reservation_title" => "يتم حجز الوحدة",
    "check_reservation_message" => "عذرا ، هذه الوحدة محجوزة من قبل موظف آخر",
));

// unit history
$lang = array_merge($lang, array(
    "unit_history" => "سجل الشقة",
    "action" => "العملية",
    "done_by" => "تمت عن طريق",
    "date" => "تاريخ",
    "asking_to_delete_unit" => "هل تريد حذف هذه الشقة ؟",
    "delete_unit" => "حذف الشقة",
    "asking_to_change_unit_to_available" => "هل تريد تغيير حالة هذه الشقة إلى متاحة؟",
    "change_to_available" => "تغيير إلى متاح",
    "change_to_signed" => "تغيير إلى موقعة",
    "asking_to_change_unit_to_signed" => "هل تريد تغيير حالة هذه الشقة إلى موقعة؟",
    "" => "تغيير إلى موقعة",
));

// unit table
$lang = array_merge($lang, array(
    "search" => "بحث",
    "add_storage_or_parking" => "إضافة مخزن أو موقف",
    "status" => "الحالة",
    "client_name" => "اسم الزبون",
    "reservation_price" => "سعر الحجز",
    "reservation_date" => "تاريخ الحجز",
    "sales_guide_name" => "اسم مندوب المبيعات",
    "contract_price" => "السعر في العقد",
    "finishing_price" => "سعر التشطيبات",
    "contract_date" => "تاريخ العقد",
));

// contract sign
$lang = array_merge($lang, array(
    "current_date" => "التاريخ الحالي",
    "sign_modal_title" => "تأكيد توقيع الشقة",
    "sign_modal_text" => "لقد أكدت أنه تم توقيع العقد بين الطرفين",
));

// cancel reason
$lang = array_merge($lang, array(
    "cancel_reason_modal_title" => "سبب إلغاء الحجز",
    "cancel_reason_modal_text" => "لماذا تريد إلغاء حجز الشقة ؟",
));

// cancel INFO
$lang = array_merge($lang, array(
    "approve" => "موافقة",
    "reject" => "رفض",
    "cancellation_info" => "معلومات إلغاء الحجز",
    "cancellation_reason" => "سبب إلغاء الحجز",
));

// Rent Page
$lang = array_merge($lang, array(
    "hint" => "ملاحظة",
    "select_one" => "يرجى اختيار شقة واحدة على الأقل",
    "info_about_changed_unit" => "معلومات حول الشقق اللي تم تغييرها",
));

// NEIGHBORHOOD Page
$lang = array_merge($lang, array(
    "add_new_neighborhood" => "إضافة حي جديد",
    "neighborhood_english_name" => "إسم الحي باللغة الأنجليزية",
    "neighborhood_arabic_name" => "إسم الحي باللغة العربية",
    "neighborhood_area" => "مساحة الحي",
    "number_of_buildings" => "عدد البنايات",
    "land_number" => "رقم الأرض",
    "hao_internal_number" => "HAO الرقم الداخلي",
    "hao_internal_date" => "HAO التاريخ الداخلي",
    "hao_established_number" => "HAO رقم الإنشاء",
    "hao_established_date" => "HAO تاريخ الإنشاء",
    "actions" => "العمليات",
    "HAO_Number" => "HAO رقم",
    "HAO_Date" => "HAO تاريخ",
    "save" => "حفظ",
    "edit_neighborhood" => "تعديل معلومات الحي",
    "delete_neighborhood" => "حذف الحي",
    "delete_neighborhood_msg" => "هل أنت متأكد أنك تريد حذف هذا الحي ، فلن تتمكن من التراجع عن هذه العملية!",
    "update" => "تعديل",
    "yes" => "نعم",
));

// Discount Page
$lang = array_merge($lang, array(
    "add_new_discount" => "إضافة خصم جديد",
    "fixed_discounts" => "خصومات ثابتة",
    "discount_name" => "إسم الخصم",
    "discount_type" => "نوع الخصم",
    "discount_value" => "قيمة الخصم",
    "discount_date" => "تاريخ الخصم",
    "password" => "الرقم السري",
    "view_password" => "عرض الرقم السري",
    "discount_description" => "وصف الخصم",
    "discount_percentage" => "نسبة الخصم",
    "percentage_discounts" => "نسبة الخصومات",
    "create_new_discount" => "إنشاء خصم جديد",
    "create" => "إنشاء",
    "edit_discount" => "تعديل الخصم",
    "discount_delete_title" => "حذف الخصم",
    "discount_delete_msg" => "هل أنت متأكد أنك تريد حذف هذا الصف ؟",
));

// Addition Page
$lang = array_merge($lang, array(
    "additions" => "الإضافات",
    "add_new_addition" => "إضافة إضافة جديدة",
    "fixed_additions" => "إضافات ثابتة",
    "addition_name" => "إسم الإضافة",
    "addition_value" => "قيمة الإضافة",
    "addition_date" => "تاريخ الإضافة",
    "addition_description" => "وصف الإضافة",
    "addition_percentage" => "نسبة الإضافة",
    "percentage_additions" => "نسبة الإضافات",
    "create_new_addition" => "إنشاء إضافة جديدة",
    "addition_type" => "نوع الإضافة",
    "delete_addition" => "حذف الإضافة",
    "delete_addition_text" => "هل أنت متأكد أنك تريد حذف هذا الصف ؟",
    "edit_addition" => "تعديل الإضافة",
));

// upload unit Page
$lang = array_merge($lang, array(
    "upload_issue_msg" => "هناك مشكلة في ملف الاكسل يرجى إصلاحها وتحميلها مرة أخرى",
    "upload" => "رفع",
    "download_unit_template" => "قم بتنزيل ملف الإكسل لإضافة الشقق",
    "download_edited_unit_template" => "قم بتحميل النسخة المعدلة من upload_units.xlsx الملف",
    "download_unit_template_for_price" => "قم بتنزيل ملف الإكسل لتعديل الأسعار",
    "upload_edieted_unit_template" => "قم بتحميل النسخة المعدلة من edit_units.xlsx الملف",
    "extension_error_msg" => "يرجى إختيار الملف المناسب",
));

// upload Parking and Storage Pages
$lang = array_merge($lang, array(
    "upload_edited_parking_template" => "قم بتحميل النسخة المعدلة من upload_parking.xlsx الملف",
    "upload_edited_storage_template" => "قم بتحميل النسخة المعدلة من upload_storages.xlsx الملف",
    "download_storage_template_edit" => "قم بتنزيل ملف القالب لإدراج المخازن التي تحتاجها للتحديثات",
    "download_parking_template_edit" => "قم بتنزيل ملف القالب لإدراج المواقف التي تحتاجها للتحديثات",
    "update_parking" => "تعديل الموقف",
    "update_storage" => "تعديل المخزن",
    "upload_storage_template" => "قم بتحميل النسخة المعدلة من upload_storage.xlsx الملف",
    "upload_parking_template" => "قم بتحميل النسخة المعدلة من upload_parking.xlsx الملف",
    "download_parking_template" => "قم بتنزيل ملف النموذج لإدراج الموقف الجديد",
    "download_storage_template" => "قم بتنزيل ملف القالب لإدراج المخزن الجديد",
    "upload_storage" => "تحميل المخزن",
    "upload_parking" => "تحميل الموقف",
));

// upload Images and Plans Pages
$lang = array_merge($lang, array(
    "upload_images" => "رقع الصور",
    "upload_plans" => "رفع المخططات",
    "filter_by" => "تصنيف حسب",
    "choose_neighborhood" => "يرجى إختيار الحي",
    "storage_or_parking" => "المخزن أو الموقف",
    "please_choose" => "يرجى إختيار",
    "selected_units" => "الشفف المختارة",
    "select_images_to_upload" => "إختيار الصور للرفع",
    "select_file_error" => "يرجى إختيار الصورة",
));

// Reservation Fees Page
$lang = array_merge($lang, array(
    "reservation_fees" => "رسوم الحجز",
    "for_example" => "على سبيل المثال",
));

// Contract Template
$lang = array_merge($lang, array(
    "prepare_the_template" => "تحضير القالب",
    "template_name" => "إسم القالب",
    "template_type" => "نوع القالب",
    "select_attribute" => "إختر القيمة المتغيرة",
    "select_type" => "إختر نوع",
    "copied" => "تم النسخ!",
    "copy" => "نسخ",
    "created_at" => "أنشئت في",
));

// Email Template
$lang = array_merge($lang, array(
    "select_email_template" => "إختر قالب البريد الإلكتروني",
    "prepare_the_email_template" => "تحضير قالب البريد الإلكتروني",
));

// Users
$lang = array_merge($lang, array(
    "create_new_user" => "إنشاء مستخدم جديد",
    "download_csv" => "تنزيل CSV",
    "user_name" => "إسم المستخدم",
    "display_name" => "إسم العرض",
    "title" => "العنوان",
    "email" => "البريد الإلكتروني",
    "group" => "المجموعة",
    "last_sign_in" => "آخر تسجيل دخول",
    "status_actions" => "الحالة/العملية",
    "disabled" => "مُعطل",
    "unactivated" => "غير فعّال",
    "active" => "فعّال",
    "activate_user" => "تفعيل المستخدم",
    "edit_user" => "تعديل المستخدم",
    "change_password" => "تغيير الرقم السري",
    "disable_user" => "تعطيل المستخدم",
    "enable_user" => "تمكين المستخدم",
    "delete_user" => "حذف المستخدم",
    "brand_new" => "علامة تجارية جديدة",
    "registered_since" => "مسجل منذ",
    "groups" => "المجموعات",
    "edit" => "تعديل",
    "activate" => "تفعيل",
    "disable" => "تعطيل",
    "enable" => "تمكين",
    "delete" => "حذف",
    "send_password_link_msg" => "أرسل للمستخدم رابطًا يسمح له باختيار كلمة المرور الخاصة به",
    "set_password_msg" => "قم بتعيين كلمة مرور المستخدم على أنها",
    "confirm_password" => "تأكيد الرقم السري",
    "submit" => "إرسال",
    "email_required" => "البريد الإلكتروني مطلوب",
));


// Mail Configurations
$lang = array_merge($lang, array(
    "mail_configurations" => "إعدادات البريد الإلكتروني",
    "host" => "المضيف",
    "port" => "المدخل",
    "auth" => "الأحقية",
    "secure" => "الأمان",
    "user" => "بريد الكتروني المرسل",
    "reservation_emails" => "إيميلات الحجز",
    "purchase_emails" => "إيميلات عملية الشراء",
    "cancellation_emails" => "إيميلات الإلغاء",
));

// MSSQL Configuration
$lang = array_merge($lang, array(
    "mssql_configuration" => "MSSQL إعدادات",
    "server" => "الخادم",
    "database" => "قاعدة البيانات",
));

// Modal Purchase
$lang = array_merge($lang, array(
    "loading_template" => "تعميل ملف القالب!",
    "contract_saved" => "تم حفظ العقد بنجاح",
    "contract_unsaved" => "لم يتم حفظ العقد",
    "select_contract" => "إختر العقد",
    "payments" => "الدفعات",
    "contracts" => "العقود",
    "complete_purchase" => "إتمام عملية الشراء",
    "preview" => "عرض",
    "save_contract" => "حفظ العقد",
    "save_payment" => "حفظ الدفعة",
    "save_all" => "حفظ الجميع",
    "number_of_payment" => "عدد الدفعات",
    "total_amount" => "مجموع القيمة",
    "first_payment" => "الدفعة الأولى",
    "period" => "الفترة",
    "start_date" => "تاريخ البداية",
    "payment" => "الدفعة",
    "payment_amount" => "قيمة الدفعة",
    "payment_date" => "تاريخ الدفعة",
    "options" => "الخيارات",
    "add_payment" => "إضافة دفعة",
    "payment_saved" => "تما حفظ الدفعة بنجاح",
    "payment_unsaved" => "لم يتم حفظ الدفعة",
    "exit" => "خروج",
    "generate" => "انشاء",
));

// top bar
$lang = array_merge($lang, array(
    "settings" => "الإعدادات",
    "logout" => "تسجيل الخروج",
    "switch_language" => "Change To English",
));

// side bar
$lang = array_merge($lang, array(
    "dashboard" => "لوحة القيادة",
    "units" => "الشقق",
    "cash_receipts" => "سندات قبض",
    "Rented_Units" => "الشقق المؤجرة",
    "Additions" => "الإضافات",
    "Upload_Units" => "تحميل الشقق",
    "Upload_images" => "تحميل صور",
    "Upload_Plans" => "تحميل المخططات",
    "Upload_Storage" => "تحميل مخازن",
    "Upload_Parking" => "تحميل المواقف",
    "Site_Settings" => "إعدادات الموقع",
    "Templates" => "القوالب",
    "Contract_Template" => "قوالب العقد",
    "Create_Template" => "إنشاء قالب عقد",
    "Templates_Transaction" => "العمليات على القوالب",
    "Email_Template" => "قالب البريد الإلكتروني",
    "Create_Email_Template" => "إنشاء قالب",
    "Mail_Configurations" => "إعدادات البريد الإلكتروني",
    "Reservation_Fees" => "رسوم الحجز",
));

$lang = array_merge($lang, array(
    "purchase_contract" => "عقد الشراء",
    "appendix_storage" => "ملحق/المخزن",
    "appendix_parking" => "ملحق/الموقف",
    "reservation_receipt" => "وصل الحجز",
    "functions" => "وظائف",
    "select_function" => "الوظائف",
    "number_to_alpha" => "أرقام إلى حروف",
    "current_date" => "التاريخ الحالي",
    "clear_payments" => "مسح جميع الدفعات",
    "selected_currency" => "العملة المختارة",
    "selected_currency_symbol" => "رمز العملة المختارة",
    "input_username" => "اسم المستخدم",
    "cal" => "عملية حسابيه",
    "exchange_rate" => "معامل تحويل العملة",
    "final_price" => "السعر النهائي",
));

$lang = array_merge($lang, array(
    "add_new_cash_receipts" => "إضافة جديد",
    "subtotal" => "المجموع الفرعي",
    "receipt_date" => "تاريخ السند",
));


return $lang;
