'use client';

import { useState, useEffect } from 'react';

export default function CourseApproval() {
  const [courses, setCourses] = useState([]);

  // Ders listesini yükle
  useEffect(() => {
    fetch('/api/courses')
      .then((res) => res.json())
      .then((data) => setCourses(data));
  }, []);

  // Onaylama işlemi
  const handleApproveCourse = async (courseId, studentId) => {
    const response = await fetch('/api/courses', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ courseId, studentId, action: 'approve' }),
    });

    if (response.ok) {
      setCourses((prevCourses) =>
        prevCourses.map((course) =>
          course.id === courseId
            ? { ...course, approvedByTeacher: [...course.approvedByTeacher, studentId] }
            : course
        )
      );
    } else {
      alert('Ders onayı başarısız!');
    }
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Ders Onaylama</h2>
      <ul className="space-y-4">
        {courses.map((course) => (
          <li key={course.id} className="border p-4 rounded-lg">
            <h3 className="text-lg font-bold mb-2">{course.name}</h3>
            {course.selectedBy.length > 0 ? (
              <ul>
                {course.selectedBy.map((studentId) => (
                  <li key={studentId} className="flex justify-between items-center border-b p-2">
                    <span>Öğrenci ID: {studentId}</span>
                    {!course.approvedByTeacher.includes(studentId) && (
                      <button
                        onClick={() => handleApproveCourse(course.id, studentId)}
                        className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                      >
                        Onayla
                      </button>
                    )}
                  </li>
                ))}
              </ul>
            ) : (
              <p className="text-gray-500">Onay bekleyen öğrenci yok.</p>
            )}
          </li>
        ))}
      </ul>
    </div>
  );
}
