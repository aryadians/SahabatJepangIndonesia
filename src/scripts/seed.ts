import { PrismaClient, UserRole } from "@prisma/client";
import bcrypt from "bcryptjs";

const prisma = new PrismaClient();

async function main() {
  const hashedPassword = await bcrypt.hash("admin123", 10);

  // Seed Admin
  await prisma.user.upsert({
    where: { email: "admin@sjigroup.co.id" },
    update: {},
    create: {
      email: "admin@sjigroup.co.id",
      name: "Super Admin SJI",
      password: hashedPassword,
      role: UserRole.ADMIN,
    },
  });

  console.log("Database seeded successfully!");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
