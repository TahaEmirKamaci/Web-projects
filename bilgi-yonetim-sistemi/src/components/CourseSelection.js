'use client';

import { useState, useEffect } from 'react';

export default function CourseSelection({ studentId }) {
  const [courses, setCourses] = useState([]);
  const [selectedCourses, setSelectedCourses] = useState([]);

  // Ders listesini yükle
  useEffect(() => {
    fetch('/api/courses')
      .then((res) => res.json())
      .then((data) => setCourses(data));
  }, []);

  // Ders seçme işlemi
  const handleSelectCourse = async (courseId) => {
    if (selectedCourses.length >= 5) {
      alert('En fazla 5 ders seçebilirsiniz!');
      return;
    }

    const response = await fetch('/api/courses', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ courseId, studentId, action: 'select' }),
    });

    if (response.ok) {
      setSelectedCourses((prev) => [...prev, courseId]);
    } else {
      alert('Ders seçimi başarısız!');
    }
  };

  return (
    <div className="course-selection-container">
      <h2 className="course-selection-title">Ders Seçimi</h2>
      <ul className="course-list">
        {courses.map((course) => (
          <li key={course.id} className="course-item">
            <span className="course-name">{course.name}</span>
            <button
              onClick={() => handleSelectCourse(course.id)}
              disabled={selectedCourses.includes(course.id)}
              className={`course-button ${
                selectedCourses.includes(course.id)
                  ? 'course-button-disabled'
                  : 'course-button-active'
              }`}
            >
              {selectedCourses.includes(course.id) ? 'Seçildi' : 'Seç'}
            </button>
          </li>
        ))}
      </ul>
    </div>
  );
}
