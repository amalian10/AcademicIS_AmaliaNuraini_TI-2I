<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'id_student';
    use HasFactory;
    protected $fillable = [
        'Nim',
        'Name',
        'Class',
        'Major',
        'Address',
        'DateOfBirth'
    ];
    public function scopeSearch($query, array $searching)
    {
        $query->when($searching['search'] ?? false, function($query, $search){
            return $query->where('name', 'like', '%'.$search.'%');
        });
    }
    public function class(){
        return $this->belongsTo(ClassModel::class);
    }

    public function course(){
        return $this->belongsToMany(Course::class, 'course_student', 'student_id')
        ->withPivot('value');;
    }
}