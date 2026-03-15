import { withAuth } from "next-auth/middleware";
import createMiddleware from 'next-intl/middleware';
import { routing } from './i18n/routing';
import { NextRequest, NextResponse } from "next/server";

const intlMiddleware = createMiddleware(routing);

const authMiddleware = withAuth(
  (req) => intlMiddleware(req),
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

  // 1. Bypass ALL API routes and static assets immediately
  if (
    pathname.startsWith('/api') || 
    pathname.startsWith('/_next') || 
    pathname.includes('.')
  ) {
    return NextResponse.next();
  }

  // 2. Define public routes
  const publicPages = ['/', '/auth/signin', '/registration', '/about', '/programs', '/classes', '/news', '/faq', '/contact'];
  
  // Regex to check if the path is a public page (with or without locale)
  const publicPathnameRegex = RegExp(
    `^(/(${routing.locales.join('|')}))?(/auth/signin|/registration|/about|/programs|/classes|/news|/contact|/faq)?$`,
    'i'
  );
  
  const isPublicPage = publicPathnameRegex.test(pathname) || pathname === '/';

  if (isPublicPage) {
    return intlMiddleware(req);
  }

  // 3. Protected routes (Admin & Portals)
  return (authMiddleware as any)(req);
}

export const config = {
  // Ensure the middleware is NOT triggered for API and static files
  matcher: ['/((?!api|_next|.*\\..*).*)']
};
