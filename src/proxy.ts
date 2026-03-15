import { withAuth } from "next-auth/middleware";
import createMiddleware from 'next-intl/middleware';
import { routing } from './i18n/routing';
import { NextRequest } from "next/server";

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

  // 1. Skip middleware for API routes and static files
  if (
    pathname.startsWith('/api') || 
    pathname.includes('.') || // matches .ico, .json, .png, etc.
    pathname.startsWith('/_next')
  ) {
    return;
  }

  const publicPathnameRegex = RegExp(
    `^(/(${routing.locales.join('|')}))?(/auth/signin|/registration|/about|/programs|/classes|/news|/contact|/faq)?$`,
    'i'
  );
  
  const isPublicPage = publicPathnameRegex.test(pathname) || pathname === '/';

  if (isPublicPage) {
    return intlMiddleware(req);
  } else {
    return (authMiddleware as any)(req);
  }
}

export const config = {
  // Match only internationalized pathnames
  matcher: ['/', '/(id|ja|en)/:path*', '/((?!api|_next/static|_next/image|favicon.ico).*)']
};
