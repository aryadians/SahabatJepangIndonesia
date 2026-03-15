import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";
import bcrypt from "bcryptjs";

export async function POST(req: Request) {
  try {
    const body = await req.json();
    const { name, email, phone, program, address } = body;

    if (!name || !email || !phone || !program) {
      return NextResponse.json({ error: "Missing required fields" }, { status: 400 });
    }

    // Check if email already exists
    const existingUser = await prisma.user.findUnique({
      where: { email }
    });

    if (existingUser) {
      return NextResponse.json({ error: "Email already registered" }, { status: 400 });
    }

    // Create User & Student in a transaction
    // Default password for new registrations is 'SJI123' (student should change it later)
    const hashedPassword = await bcrypt.hash("SJI123", 10);

    const result = await prisma.$transaction(async (tx) => {
      const user = await tx.user.create({
        data: {
          name,
          email,
          password: hashedPassword,
          role: "STUDENT",
        },
      });

      // Find program ID by name or use a default
      const programData = await tx.program.findFirst({
        where: { name: { contains: program } }
      });

      const student = await tx.student.create({
        data: {
          userId: user.id,
          studentId: `SJI-${Math.floor(1000 + Math.random() * 9000)}`,
          phone,
          address,
          programId: programData?.id,
          status: "REGISTRATION",
        },
      });

      return { user, student };
    });

    return NextResponse.json({ message: "Registration successful", data: result }, { status: 201 });
  } catch (error: any) {
    console.error("REGISTRATION_ERROR", error);
    return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
  }
}
