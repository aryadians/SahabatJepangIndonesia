import { withAuth } from "next-auth/middleware";
import createMiddleware from 'next-intl/middleware';
import { routing } from './i18n/routing';
import { NextRequest, NextResponse } from "next/server";

const publicPages = [
  '/',
  '/auth/signin',
  '/registration',
  '/about',
  '/about/teachers',
  '/programs',
  '/classes',
  '/news',
  '/faq',
  '/contact'
];

const intlMiddleware = createMiddleware(routing);

const authMiddleware = withAuth(
  function onSuccess(req) {
    return intlMiddleware(req);
  },
  {
    callbacks: {
      authorized: ({ token }) => !!token,
    },
    pages: {
      signIn: '/auth/signin',
    },
  }
);

export default function middleware(req: NextRequest) {
  const { pathname } = req.nextUrl;

  // 1. ABSOLUTELY BYPASS API AND STATIC FILES
  // This prevents NextAuth fetch errors (Unexpected token <)
  if (
    pathname.startsWith('/api') || 
    pathname.startsWith('/_next') || 
    pathname.includes('.')
  ) {
    return NextResponse.next();
  }

  const publicPathnameRegex = RegExp(
    `^(/(${routing.locales.join('|')}))?(${publicPages
      .flatMap((p) => (p === '/' ? ['', '/'] : [p]))
      .join('|')})/?$`,
    'i'
  );
  const isPublicPage = publicPathnameRegex.test(pathname);

  if (isPublicPage) {
    return intlMiddleware(req);
  } else {
    return (authMiddleware as any)(req);
  }
}

export const config = {
  // Use a catch-all but rely on the function logic for exclusions
  matcher: ['/((?!_next|api|favicon.ico).*)']
};
