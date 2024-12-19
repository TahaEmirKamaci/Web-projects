const users = [
    { id: 1, email: 'student@example.com', password: '12345', role: 'student' },
    { id: 2, email: 'teacher@example.com', password: '12345', role: 'teacher' },
  ];
  
  export async function POST(req) {
    const { email, password } = await req.json();
  
    const user = users.find((u) => u.email === email && u.password === password);
    if (user) {
      return new Response(
        JSON.stringify({ success: true, role: user.role }),
        { status: 200, headers: { 'Content-Type': 'application/json' } }
      );
    } else {
      return new Response(JSON.stringify({ success: false, message: 'Hatalı giriş bilgileri' }), {
        status: 401,
        headers: { 'Content-Type': 'application/json' },
      });
    }
  }
  