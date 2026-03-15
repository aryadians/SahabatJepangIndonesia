import { withAuth } from "next-auth/middleware";
import createMiddleware from 'next-intl/middleware';
import { routing } from './i18n/routing';
import { NextRequest, NextResponse } from "next/server";

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

  // 1. ABSOLUTELY SKIP middleware for API, static files, and internal paths
  if (
    pathname.startsWith('/api/') || 
    pathname.startsWith('/_next/') ||
    pathname.includes('.') ||
    pathname === '/favicon.ico' ||
    pathname === '/manifest.json'
  ) {
    return NextResponse.next();
  }

  // 2. Define which pages are public (accessible without login)
  const publicPathnameRegex = RegExp(
    `^(/(${routing.locales.join('|')}))?(/auth/signin|/registration|/about|/programs|/classes|/news|/contact|/faq)?$`,
    'i'
  );
  
  const isPublicPage = publicPathnameRegex.test(pathname) || pathname === '/';

  // 3. Handle public vs protected routing
  if (isPublicPage) {
    return intlMiddleware(req);
  } else {
    // PROTECTED ROUTES (Admin, Student Portal, Teacher Portal)
    return (authMiddleware as any)(req);
  }
}

export const config = {
  // Matcher ignoring all internal and static paths
  matcher: [
    /*
     * Match all request paths except for the ones starting with:
     * - api (API routes)
     * - _next/static (static files)
     * - _next/image (image optimization files)
     * - favicon.ico, manifest.json (static files)
     */
    '/((?!api|_next/static|_next/image|favicon.ico|manifest.json|.*\\..*).*)'
  ]
};
