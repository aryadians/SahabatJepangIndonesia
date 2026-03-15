const { PrismaClient } = require('@prisma/client');
const bcrypt = require('bcryptjs');
require('dotenv').config();

const prisma = new PrismaClient();

async function main() {
  const hashedPassword = await bcrypt.hash('admin123', 10);

  // 1. Seed Admin
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

  // 2. Seed Programs
  const programs = [
    { name: 'Tokutei Ginou (SSW)', category: 'SSW', basePrice: 5500000, description: 'Program tenaga kerja ahli khusus ke Jepang.' },
    { name: 'Magang Jepang (Ginou Jisshuusei)', category: 'Magang', basePrice: 4500000, description: 'Program magang kerja 1-3 tahun di Jepang.' },
    { name: 'Kursus Bahasa Jepang', category: 'Kursus', basePrice: 2500000, description: 'Persiapan ujian JLPT & JFT-Basic.' }
  ];

  for (const p of programs) {
    await prisma.program.upsert({
      where: { name: p.name },
      update: {},
      create: p
    });
  }

  // 3. Seed Site Content (CMS)
  const contents = [
    { key: 'hero_title', value: 'Wujudkan Karir Impian di Jepang' },
    { key: 'contact_phone', value: '+62 813-3327-0022' },
    { key: 'contact_email', value: 'official@sjigroup.co.id' }
  ];

  for (const c of contents) {
    await prisma.siteContent.upsert({
      where: { key: c.key },
      update: {},
      create: c
    });
  }

  // 4. Seed FAQs
  const faqs = [
    { question: 'Apa syarat utama mendaftar?', answer: 'Minimal lulusan SMA/SMK sederajat dan usia 18-26 tahun.', order: 1 },
    { question: 'Berapa lama pelatihannya?', answer: 'Rata-rata 4-6 bulan hingga siap terbang.', order: 2 }
  ];

  for (const f of faqs) {
    await prisma.fAQ.upsert({
      where: { question: f.question },
      update: { answer: f.answer, order: f.order },
      create: f
    });
  }

  console.log('Database seeded successfully!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
