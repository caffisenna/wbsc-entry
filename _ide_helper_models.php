<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class Entry_info
 *
 * @package App\Models
 * @version October 15, 2022, 10:45 pm JST
 * @property string $furigana
 * @property string $gender
 * @property string $bs_id
 * @property string $sc_number
 * @property string $sc_number_done
 * @property string $prefecture
 * @property string $district
 * @property string $dan
 * @property string $troop
 * @property string $troop_role
 * @property string $cell_phone
 * @property string $zip
 * @property string $address
 * @property string $district_role
 * @property string $prefecture_role
 * @property string $scout_camp
 * @property string $bs_basic_course
 * @property string $wb_basic1_category
 * @property string $wb_basic1_number
 * @property string $wb_basic1_date
 * @property string $wb_adv1_category
 * @property string $wb_adv1_number
 * @property string $wb_adv1_date
 * @property string $service_hist1_role
 * @property string $service_hist1_term
 * @property string $health_illness
 * @property string $health_memo
 * @property string $commi_checked_at
 * @property string $ais_checked_at
 * @property string $gm_checked_at
 * @property int $id
 * @property int|null $user_id
 * @property string $division_number
 * @property \Illuminate\Support\Carbon $birthday
 * @property string|null $wb_basic2_category
 * @property string|null $wb_basic2_number
 * @property string|null $wb_basic2_date
 * @property string|null $wb_basic3_category
 * @property string|null $wb_basic3_number
 * @property string|null $wb_basic3_date
 * @property string|null $wb_basic4_category
 * @property string|null $wb_basic4_number
 * @property string|null $wb_basic4_date
 * @property string|null $wb_basic5_category
 * @property string|null $wb_basic5_number
 * @property string|null $wb_basic5_date
 * @property string|null $wb_adv2_category
 * @property string|null $wb_adv2_number
 * @property string|null $wb_adv2_date
 * @property string|null $wb_adv3_category
 * @property string|null $wb_adv3_number
 * @property string|null $wb_adv3_date
 * @property string|null $wb_adv4_category
 * @property string|null $wb_adv4_number
 * @property string|null $wb_adv4_date
 * @property string|null $wb_adv5_category
 * @property string|null $wb_adv5_number
 * @property string|null $wb_adv5_date
 * @property string|null $service_hist2_role
 * @property string|null $service_hist2_term
 * @property string|null $service_hist3_role
 * @property string|null $service_hist3_term
 * @property string|null $service_hist4_role
 * @property string|null $service_hist4_term
 * @property string|null $service_hist5_role
 * @property string|null $service_hist5_term
 * @property string|null $assignment_sc
 * @property string|null $assignment_division
 * @property string|null $face_picture
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $trainer_sc_checked_at
 * @property string|null $trainer_sc_name
 * @property \Illuminate\Support\Carbon|null $trainer_division_checked_at
 * @property string|null $trainer_division_name
 * @property string|null $gm_name
 * @property string|null $fee_checked_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\Entry_infoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereAisCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereAssignmentDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereAssignmentSc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereBsBasicCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereBsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereCommiCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereDan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereDistrictRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereDivisionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereFacePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereFeeCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereFurigana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereGmCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereGmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereHealthIllness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereHealthMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info wherePrefectureRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereScNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereScNumberDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereScoutCamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist1Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist1Term($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist2Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist2Term($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist3Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist3Term($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist4Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist4Term($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist5Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereServiceHist5Term($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTrainerDivisionCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTrainerDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTrainerScCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTrainerScName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTroop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereTroopRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv1Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv1Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv1Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv2Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv2Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv2Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv3Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv3Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv3Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv4Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv4Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv4Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv5Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv5Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbAdv5Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic1Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic1Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic1Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic2Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic2Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic2Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic3Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic3Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic3Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic4Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic4Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic4Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic5Category($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic5Date($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereWbBasic5Number($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info whereZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry_info withoutTrashed()
 */
	class Entry_info extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property int $is_admin
 * @property int $is_staff
 * @property string|null $is_commi
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $face_picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entry_info|null $entry_info
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsCommi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * Class course_list
 *
 * @package App\Models
 * @version April 7, 2023, 11:14 am JST
 * @property string $category
 * @property string $number
 * @property string $director
 * @property string $place
 * @property string $day_start
 * @property string $day_end
 * @property string $guidance_date
 * @property string $deadline
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\course_listFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|course_list newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course_list newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course_list onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|course_list query()
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereDayEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereDayStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereGuidanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course_list withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|course_list withoutTrashed()
 */
	class course_list extends \Eloquent {}
}

namespace App\Models{
/**
 * Class division_list
 *
 * @package App\Models
 * @version April 15, 2023, 2:32 pm JST
 * @property string $division
 * @property string $number
 * @property string $director
 * @property string $place
 * @property string $day_start
 * @property string $guidance_date
 * @property string $deadline
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\division_listFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|division_list newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|division_list newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|division_list onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|division_list query()
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereDayStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereGuidanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|division_list withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|division_list withoutTrashed()
 */
	class division_list extends \Eloquent {}
}

