import CourseSelection from '../../components/CourseSelection';

export default function StudentPage() {
  const studentId = 1; 

  return (
    <div>
      <CourseSelection studentId={studentId} />
    </div>
  );
}
