let courses = [
    { id: 1, name: 'Matematik', selectedBy: [], approvedByTeacher: [] },
    { id: 2, name: 'Fizik', selectedBy: [], approvedByTeacher: [] },
    { id: 3, name: 'Kimya', selectedBy: [], approvedByTeacher: [] },
    { id: 4, name: 'Biyoloji', selectedBy: [], approvedByTeacher: [] },
    { id: 5, name: 'Tarih', selectedBy: [], approvedByTeacher: [] },
  ];
  
  export async function GET(req) {
    return new Response(JSON.stringify(courses), { status: 200 });
  }
  
  export async function POST(req) {
    const { courseId, studentId, action } = await req.json();
  
    const course = courses.find((c) => c.id === courseId);
    if (!course) {
      return new Response(JSON.stringify({ success: false, message: 'Ders bulunamadı' }), { status: 404 });
    }
  
    if (action === 'select') {
      if (!course.selectedBy.includes(studentId)) course.selectedBy.push(studentId);
    } else if (action === 'approve') {
      if (!course.approvedByTeacher.includes(studentId)) course.approvedByTeacher.push(studentId);
    }
  
    return new Response(JSON.stringify({ success: true, courses }), { status: 200 });
  }
  