const { PrismaClient } = require('@prisma/client');
const bcrypt = require('bcryptjs');
require('dotenv').config();

const prisma = new PrismaClient({
  datasourceUrl: process.env.DATABASE_URL
});

async function main() {
  const hashedPassword = await bcrypt.hash('admin123', 10);

  await prisma.user.upsert({
    where: { email: 'admin@sjigroup.co.id' },
    update: {},
    create: {
      email: 'admin@sjigroup.co.id',
      name: 'Super Admin SJI',
      password: hashedPassword,
      role: 'ADMIN',
    },
  });

  console.log('Admin user seeded!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
